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

use Multidimensional\Usps\Address;
use Multidimensional\Usps\Exception\AddressValidateException;
use Multidimensional\XmlArray\XMLArray;

class AddressValidate extends USPS
{

    protected $apiClass = 'Verify';
    protected $apiMethod = 'AddressValidateRequest';

    protected $addresses = [];

    protected $includeOptionalElements = false;
    protected $returnCarrierRoute = false;

    const FIELDS = [
        'AddressValidateRequest' => [
            'type' => 'array',
            'fields' => [
                'IncludeOptionalElements' => [
                    'type' => 'boolean'
                ],
                'ReturnCarrierRoute' => [
                    'type' => 'boolean'
                ],
                'Address' => [
                    'type' => 'group',
                    'fields' => Address::FIELDS
                ]
            ]
        ]
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        if (isset($config['IncludeOptionalElements'])) {
            $this->setIncludeOptionalElements($config['IncludeOptionalElements']);
        }
        if (isset($config['ReturnCarrierRoute'])) {
            $this->setReturnCarrierRoute($config['ReturnCarrierRoute']);
        }
    }

    /**
     * @param \Multidimensional\Usps\Address $address
     * @return bool
     * @throws AddressValidateException
     */
    public function addAddress(Address $address)
    {
        if (count($this->addresses) < 5) {
            $this->addresses[] = $address->toArray();
            return true;
        }

        throw new AddressValidateException('Address not added. You can only have a maximum of 5 addresses included in each look up request.');
    }

    /**
     * @param bool $boolean
     * @return void
     */
    public function setIncludeOptionalElements($boolean)
    {
        $this->includeOptionalElements = (bool) $boolean;
    }

    /**
     * @param bool $boolean
     * @return void
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
            $array['AddressValidateRequest']['IncludeOptionalElements'] = 'true';
        }

        if ($this->returnCarrierRoute === true) {
            $array['AddressValidateRequest']['ReturnCarrierRoute'] = 'true';
        }

        $array['AddressValidateRequest']['Address'] = $this->addresses;

        return $array;
    }

    /**
     * @return array
     * @throws AddressValidateException
     */
    public function validate()
    {
        $xml = $this->buildXML($this->toArray());
        if ($this->validateXML($xml)) {
            $result = $this->request($xml);
            return $this->parseResult($result);
        } else {
            throw new AddressValidateException();
        }
    }

    /**
     * @param string $result
     * @return array
     */
    protected function parseResult($result)
    {
        $xmlArray = new XMLArray;
        $array = $xmlArray->generateArray($result);
        foreach ($array as $key => $value) {
            unset($array[$key]['@ID']);
            $array[$value['@ID']] = $array[$key];
            unset($array[$key]);
        }
        return $array;
    }
}
