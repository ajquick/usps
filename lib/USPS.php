<?php
/**
 *      __  ___      ____  _     ___                           _                    __
 *     /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *    / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *   / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *  /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 *  @author Multidimension.al
 *  @copyright Copyright © 2016-2017 Multidimension.al - All Rights Reserved
 *  @license Proprietary and Confidential
 *
 *  NOTICE:  All information contained herein is, and remains the property of
 *  Multidimension.al and its suppliers, if any.  The intellectual and
 *  technical concepts contained herein are proprietary to Multidimension.al
 *  and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 *  process, and are protected by trade secret or copyright law. Dissemination
 *  of this information or reproduction of this material is strictly forbidden
 *  unless prior written permission is obtained.
 */

namespace Multidimensional\Usps;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Multidimensional\DomArray\DOMArray;
use Multidimensional\Usps\Exception\USPSException;
use Multidimensional\XmlArray\XMLArray;

class USPS
{
    const PRODUCTION_URI = 'https://secure.shippingapis.com/ShippingAPI.dll';
    const TESTING_URI = 'https://secure.shippingapis.com/ShippingAPITest.dll';

    protected $userId;
    protected $password;
    public $domArray;
    public $testMode = false;

    const apiClasses = [
        'CityStateLookup'   => 'CityStateLookupRequest',
        'IntlRateV2'        => 'IntlRateV2Request',
        'RateV4'            => 'RateV4Request',
        'TrackV2'           => 'TrackFieldRequest',
        'Verify'            => 'AddressValidateRequest',
        'ZipCodeLookup'     => 'ZipCodeLookupRequest'
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (isset($config['userId'])) {
            $this->userId = $config['userId'];
        }
        if (isset($config['password'])) {
            $this->password = $config['password'];
        }

        $this->domArray = new DOMArray();
    }

    /**
     * @param $userId
     * @param $password
     * @return void
     */
    public function setCredentials($userId, $password = null)
    {
        $this->userId = $userId;
        $this->password = $password;
    }

    /**
     * @param bool $boolean
     * @return void
     */
    public function setTestMode($boolean = true)
    {
        $this->testMode = (bool) $boolean;
    }

    /**
     * @param bool $boolean
     * @return void
     */
    public function setProductionMode($boolean = true)
    {
        $this->testMode = (bool) !$boolean;
    }

    /**
     * @param string $xml
     * @return string
     * @throws USPSException
     */
    public function request($xml)
    {

        if (self::apiClasses[$this->apiClass] !== null || array_key_exists($this->apiClass, self::apiClasses)) {
        } else {
            throw new USPSException('Invalid API Class.');
        }

        $client = new Client();

        if ($this->testMode === true) {
            $requestUri = self::TESTING_URI . '?API=' . $this->apiClass;
        } else {
            $requestUri = self::PRODUCTION_URI . '?API=' . $this->apiClass;
        }

        $request = new Request('POST', $requestUri, ['Content-Type' => 'text/xml; charset=UTF8'], $xml);
        $response = $client->send($request);

        return $response->xml();
    }

    /**
     * @param array $array
     * @return string
     */
    protected function buildXML($array)
    {
        if ($this->userId) {
            /** @noinspection PhpUndefinedFieldInspection */
            $array[$this->apiMethod]['@USERID'] = $this->userId;
        }
        $this->domArray->loadArray($array);
        $this->domArray->formatOutput = true;
        return $this->domArray->saveXML();
    }

    /**
     * @param string $xml
     * @return bool
     * @throws USPSException
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

            throw new USPSException($error->code . ': ' . trim($error->message));
        }
    }
}
