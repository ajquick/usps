<?php
/**
 *      __  ___      ____  _     ___                           _                    __
 *     /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *    / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *   / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *  /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * @author Multidimension.al
 * @copyright Copyright © 2016-2017 Multidimension.al - All Rights Reserved
 * @license Proprietary and Confidential
 *
 *  NOTICE:  All information contained herein is, and remains the property of
 *  Multidimension.al and its suppliers, if any.  The intellectual and
 *  technical concepts contained herein are proprietary to Multidimension.al
 *  and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 *  process, and are protected by trade secret or copyright law. Dissemination
 *  of this information or reproduction of this material is strictly forbidden
 *  unless prior written permission is obtained.
 */

namespace Multidimensional\USPS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Multidimensional\DomArray\DOMArray;
use Multidimensional\XmlArray\XMLArray;

class USPS
{
    const SECURE_PRODUCTION_URI = 'https://secure.shippingapis.com/ShippingAPI.dll';
    const SECURE_TESTING_URI = 'https://secure.shippingapis.com/ShippingAPITest.dll';
    const PRODUCTION_URI = 'http://production.shippingapis.com/ShippingAPI.dll';
    const TESTING_URI = 'http://stg-production.shippingapis.com/ShippingAPI.dll';
    const API_CLASSES = [
        'CityStateLookup' => 'CityStateLookupRequest',
        'IntlRateV2' => 'IntlRateV2Request',
        'RateV4' => 'RateV4Request',
        'TrackV2' => 'TrackFieldRequest',
        'Verify' => 'AddressValidateRequest',
        'ZipCodeLookup' => 'ZipCodeLookupRequest'
    ];
    const ERROR_RESPONSE = [
        'Error' => [
            'type' => 'array',
            'fields' => [
                'Number' => [
                    'type' => 'string'
                ],
                'Source' => [
                    'type' => 'string'
                ],
                'Description' => [
                    'type' => 'string'
                ],
                'HelpFile' => [
                    'type' => 'string'
                ],
                'HelpContext' => [
                    'type' => 'string'
                ],
            ]
        ]
    ];
    public $testMode = false;
    public $secureMode = false;
    public $apiClass;
    public $apiMethod;
    protected $userID;
    protected $password;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (isset($config['userID'])) {
            $this->setUserID($config['userID']);
        }
        if (isset($config['password'])) {
            $this->setPassword($config['password']);
        }
    }

    /**
     * @param string $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $userID
     * @param string|null $password
     */
    public function setCredentials($userID, $password = null)
    {
        $this->setUserID($userID);
        $this->setPassword($password);
    }

    public function setProductionMode()
    {
        $this->setTestMode(false);
    }

    /**
     * @param bool $boolean
     */
    public function setTestMode($boolean = true)
    {
        $this->testMode = (bool)$boolean;
    }

    /**
     * @param bool $boolean
     */
    public function setSecureMode($boolean = true)
    {
        $this->secureMode = (bool)$boolean;
    }

    /**
     * @param string $xml
     * @return string
     * @throws Exception
     */
    protected function request($xml)
    {
        if (isset($this->apiClass) && (self::API_CLASSES[$this->apiClass] || array_key_exists($this->apiClass, self::API_CLASSES))) {
        } else {
            throw new Exception('Invalid API Class.');
        }

        if ($this->testMode === true && $this->secureMode === true) {
            $baseUri = self::SECURE_TESTING_URI;
        } elseif ($this->secureMode === true) {
            $baseUri = self::SECURE_PRODUCTION_URI;
        } elseif ($this->testMode === true) {
            $baseUri = self::TESTING_URI;
        } else {
            $baseUri = self::PRODUCTION_URI;
        }

        try {
            $client = new Client(['base_uri' => $baseUri]);
            $requestUri = '?API=' . urlencode($this->apiClass);
            $requestUri .= '&XML=' . urlencode($xml);
            $response = $client->request('GET', $requestUri);
            return $response->getBody();
        } catch (ClientException $e) {
            throw $e;
        }
    }

    /**
     * @param array $array
     * @return string
     */
    protected function buildXML($array)
    {
        if ($this->userID) {
            $array[$this->apiMethod]['@USERID'] = $this->userID;
        }
        $dom = new DOMArray('1.0', 'UTF-8');
        $dom->loadArray($array);
        $dom->formatOutput = true;
        return $dom->saveXML();
    }

    /**
     * @param string $xml
     * @return true
     * @throws Exception
     */
    protected function validateXML($xml)
    {

        $dom = new \DOMDocument();
        $dom->loadXML($xml);

        libxml_use_internal_errors(true);

        $schemaPath = __DIR__ . '/../xsd/' . $this->apiMethod . '.xsd';

        if ($dom->schemaValidate($schemaPath)) {
            return true;
        } else {
            $error = libxml_get_errors();
            libxml_clear_errors();

            throw new Exception($error->message);
        }
    }

    /**
     * @param string $result
     * @return array
     */
    protected function parseResult($result)
    {
        return XMLArray::generateArray($result);
    }
}
