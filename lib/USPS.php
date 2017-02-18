<?php
/**
 *     __  ___      ____  _     ___                           _                    __
 *    /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *   / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *  / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 * /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * CONFIDENTIAL
 *
 * © 2017 Multidimension.al - All Rights Reserved
 *
 * NOTICE:  All information contained herein is, and remains the property of
 * Multidimension.al and its suppliers, if any.  The intellectual and
 * technical concepts contained herein are proprietary to Multidimension.al
 * and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law. Dissemination
 * of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained.
 */

namespace Multidimensional\Usps;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Multidimensional\DomArray\DOMArray;
use Multidimensional\XmlArray\XMLArray;

class USPS
{
const PRODUCTION_URI = 'https://secure.shippingapis.com/ShippingAPI.dll';
const TESTING_URI = 'https://secure.shippingapis.com/ShippingAPITest.dll';

private $userId;
private $password;
public $dom;
public $testMode = false;
protected $error = false;
protected $errorCode = null;
protected $errorMessage = null;

private static $apiClasses = [
'CityStateLookup' => 'CityStateLookupRequest',
'IntlRateV2'  => 'IntlRateV2Request',
'RateV4'  => 'RateV4Request',
'TrackV2' => 'TrackFieldRequest',
'Verify'  => 'AddressValidateRequest',
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
public function request($apiClass)
{

if (self::$apiClasses[$apiClass] !== null || array_key_exists($apiClass, self::$apiClasses)) {
} else {
$this->error = true;
$this->errorMessage = 'Invalid API Class';
$this->errorCode = '';
return false;
}

$client = new Client();

if ($this->testMode === true) {
$requestUri = self::TESTING_URI . '?API=' . $apiClass;
} else {
$requestUri = self::PRODUCTION_URI . '?API=' . $apiClass;
}

$request = new Request('POST', $requestUri, ['Content-Type' => 'text/xml; charset=UTF8'], $xml);
$response = $client->send($request);

return $response->xml();
}

protected function buildXML($array)
{
$array['@USERID'] = $this->userId;
return $this->dom->loadArray($array);
}

/**
 * @param DOMDocument $dom
 * @param string  $apiClass
 * @return bool
 */
protected function validateXML(DOMDocument $dom, $apiClass)
{
libxml_use_internal_errors(true);

$schemaPath = __DIR__ . '/../xsd/' . $this->apiClasses[$apiClass] . '.xsd';

if ($dom->schemaValidate($schemaPath)) {
return true;
} else {
$error = libxml_get_errors();

$this->error = true;
$this->errorMessage = trim($error->message);
$this->errorCode = $error->code;

libxml_clear_errors();

return false;
}
}

/**
 * @return bool
 */
public function isSuccess()
{
if ($this->error) {
return false;
} else {
return true;
}
}

/**
 * @return bool
 */
public function isError()
{
if ($this->error) {
return true;
} else {
return false;
}
}

/**
 * @return null|string
 */
public function getErrorMessage()
{
return $this->errorMessage;
}

/**
 * @return null|string
 */
public function getErrorCode()
{
return $this->errorCode;
}
}
