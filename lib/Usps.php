<?php
/**
 * CONFIDENTIAL
 *
 * © 2017 Multidimension.al - All Rights Reserved
 * 
 * NOTICE:  All information contained herein is, and remains
 * the property of Multidimension.al and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to Multidimension.al and its suppliers
 * and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained.
 */

namespace Multidimensional\Usps;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Multidimensional\DomArray;
use Multidimensional\XmlArray;

class Usps
{
    const PRODUCTION_URI = 'https://secure.shippingapis.com/ShippingAPI.dll';
    const TESTING_URI = 'https://secure.shippingapis.com/ShippingAPITest.dll';
    
    private $userId;
    private $password;
    public $testMode = false;
    public $dom;
    
    private static $apiClasses = [
        'CityStateLookup' => 'CityStateLookupRequest',
        'IntlRateV2'      => 'IntlRateV2Request'
        'RateV4'          => 'RateV4Request',
        'TrackV2'         => 'TrackFieldRequest',
        'Verify'          => 'AddressValidateRequest',
        'ZipCodeLookup'   => 'ZipCodeLookupRequest'
    ];

    /**
     * @return void
     */
    public function __construct(array $config = [])
    {
        if (isset($config['userId'])) {
            $this->userId = $config['userId'];    
        }
        
        $this->dom = new DOMArray();
        
    }

    /**
     * @return void
     */
    public function setCredentials($userId, $password)
    {
        $this->userId = $userId;
        $this->password = $password;
    }
    
    /**
     * @param bool $boolean
     * @return bool
     */
    public function setTestMode($boolean = true)
    {
        return $this->testMode = (bool) $boolean;
    }
    
    /**
     * @param bool $boolean
     * @return bool
     */
    public function setProductionMode($boolean = true)
    {
        $this->testMode = (bool) !$boolean;
        
        return $boolean;
    }
    
    /**
     * @param string $apiClass
     * @param string $xml
     * @return string
     */
    public function request($apiClass, $xml)
    {
    
        if (isset(self::$apiClasses[$apiClass]) || array_key_exists($apiClass, self::$apiClasses)) {
        } else {
            return false;
        }
    
        $client = new Client();
        
        if ($this->testMode === true) {
            $requestUri = TESTING_URI . '?API=' . $apiClass;
        } else {
            $requestUri = PRODUCTION_URI . '?API=' . $apiClass;
        }
        
        $request = new Request('POST', $requestUri, ['Content-Type' => 'text/xml; charset=UTF8'], $xml);
        $response = $client->send($request);
        
        return $response->xml();
        
    }
	
	public function buildXML($array)
	{
		$array['@USERID'] = $this->userId;
		return $this->dom->loadArray($array);	
	}
	
	public function validateXML(DOMDocument $dom)
	{
		if	($dom->schemaValidate('filename')) {
			return true;
		} else {
			return false;	
		}
	}
}
