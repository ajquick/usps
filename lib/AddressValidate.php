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

use Multidimensional\Usps\Address;
use Multidimensional\XmlArray;

class AddressValidate extends USPS
{

    public $apiClass = 'Verify';

    protected $addresses = [];

    private $includeOptionalElements = false;
    private $returnCarrierRoute = false;

    const FIELDS = [
    'IncludeOptionalElements' => [
    'type' => 'boolean'
    ],
    'ReturnCarrierRoute' => [
    'type' => 'boolean'
    ],
    'Address' => [
    'type' => 'Address',
    'fields' => Address::FIELDS;
    ]
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

/**
 * @param Address $address
 * @return true|false
 */
    public function addAddress(Address $address)
    {
        if (count($this->addresses) < 5) {
            $this->addresses[] = $address->toArray();
            return true;
        } else {
            return false;
        }
    }

/**
 * @param bool $boolean
 */
    public function setIncludeOptionalElements($boolean)
    {
        $this->includeOptionalElements = (bool) $boolean;
    }

/**
 * @param bool $boolean
 */
    public function setReturnCarrierRoute($boolean)
    {
        $this->returnCarrierRoute = (bool) $boolean;
    }

/**
 * @return array
 */
    public function toArray()
    {
        $array = [];
        if ($this->includeOptionalElements === true) {
            $array['IncludeOptionalElements'] = 'true';
        }

        if ($this->returnCarrierRoute === true) {
            $array['ReturnCarrierRoute'] = 'true';
        }

        $array['Address'] = $this->addresses;

        return $array;
    }

/**
 * @return array
 */
    public function validate()
    {
        $xml = $this->buildXML($this->toArray());
        if ($this->validateXML($xml, $this->apiClass)) {
            $result = $this->request($this->apiClass);
            return $this->parseResult($result);
        } else {
            return false;
        }
    }

/**
 * @param string $result
 * @return array
 */
    private function parseResult($result)
    {
        $array = (new XMLArray)->generateArray($result);
        foreach ($array as $key => $value) {
            unset($array[$key]['@ID']);
            $array[$value['@ID']] = $array[$key];
            unset($array[$key]);
        }
        return $array;
    }
}
