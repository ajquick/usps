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

namespace Multidimensional\USPS;

use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Exception\ValidationException;
use Multidimensional\ArrayValidation\Validation;
use Multidimensional\USPS\Address;
use Multidimensional\USPS\Exception\AddressValidateException;
use Multidimensional\XmlArray\XMLArray;

class AddressValidate extends USPS
{
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

    const RESPONSE = [
        'AddressValidateResponse' => [
            'type' => 'array',
            'fields' => [
                'Address' => [
                    'type' => 'group',
                    'fields' => [
                        '@ID' => [
                            'type' => 'integer'
                        ],
                        'FirmName' => [
                            'type' => 'string'
                        ],
                        'Address1' => [
                            'type' => 'string'
                        ],
                        'Address2' => [
                            'type' => 'string'
                        ],
                        'City' => [
                            'type' => 'string'
                        ],
                        'State' => [
                            'type' => 'string',
                            'pattern' => '[A-Z]{2}'
                        ],
                        'Urbanization' => [
                            'type' => 'string'
                        ],
                        'Zip5' => [
                            'type' => 'string',
                            'pattern' => '\d{5}'
                        ],
                        'Zip4' => [
                            'type' => 'string',
                            'pattern' => '\d{4}'
                        ],
                        'DeliveryPoint' => [
                            'type' => 'string'
                        ],
                        'CarrierRoute' => [
                            'type' => 'string'
                        ],
                        'ReturnText' => [
                            'type' => 'string'
                        ]
                    ]
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

        if (is_array($config) && isset($config['Address'])) {
            if (is_array($config['Address'])) {
                foreach ($config['Address'] as $addressObject) {
                    if(is_object($addressObject) && $addressObject instanceof Address) {
                        $this->addAddress($addressObject);
                    }
                }
            } elseif(is_object($config['Address']) && $config['Address'] instanceof Address) {
                $this->addAddress($config['Address']);
            }
        }

        $this->apiClass = 'Verify';
        $this->apiMethod = 'AddressValidateRequest';
    }

    /**
     * @param \Multidimensional\Usps\Address $address
     * @throws AddressValidateException
     */
    public function addAddress(Address $address)
    {
        if (count($this->addresses) < 5) {
            $this->addresses[] = $address->toArray();
        } else {
            throw new AddressValidateException('Address not added. You can only have a maximum of 5 addresses included in each look up request.');
        }
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
            $array['AddressValidateRequest']['IncludeOptionalElements'] = true;
        }

        if ($this->returnCarrierRoute === true) {
            $array['AddressValidateRequest']['ReturnCarrierRoute'] = true;
        }

        $array['AddressValidateRequest']['Address'] = $this->addresses;

        try {
            if (is_array($array) && count($array)) {
                Validation::validate($array, self::FIELDS);
            } else {
                return null;
            }
        } catch (ValidationException $e) {
            throw new AddressValidateException($e->getMessage());
        }

        return $array;
    }

    /**
     * @return array
     * @throws AddressValidateException
     */
    public function validate()
    {
        try {
            $xml = $this->buildXML($this->toArray());
            if ($this->validateXML($xml)) {
                $result = $this->request($xml);
                return $this->parseResult($result);
            } else {
                throw new AddressValidateException('Unable to validate XML.');
            }
        } catch (ValidationException $e) {
            throw new AddressValidateException($e->getMessage());
        }
    }

    /**
     * @param string $result
     * @return array
     * @throws AddressValidateException
     */
    protected function parseResult($result)
    {
        $array = parent::parseResult($result);
        $array = Sanitization::sanitize($array, self::RESPONSE);

        try {
            if (is_array($array) && count($array)) {
                Validation::validate($array, self::RESPONSE);
            } else {
                return null;
            }
        } catch (ValidationException $e) {
            throw new AddressValidateException($e->getMessage());
        }

        $array = $array['AddressValidateResponse'];

        if (is_array($array) && count($array) && (isset($array['Address']) || array_key_exists('Address', $array) )) {

            $array = $array['Address'];

            foreach ($array AS $key => $value) {
                if (is_int($key)) {
                    list($array[$key]['Address2'], $array[$key]['Address1']) = [isset($value['Address1']) ? $value['Address1'] : null, isset($value['Address2']) ? $value['Address2'] : null];
                } else {
                    list($array['Address2'], $array['Address1']) = [isset($array['Address1']) ? $array['Address1'] : null, isset($array['Address2']) ? $array['Address2'] : null];
                    break;
                }
            }

            foreach ($array AS $key => $value) {
                if (is_int($key)) {
                    $array[$value['@ID']] = $value;
                    unset($array[$key]);
                } else {
                    $array2[$array['@ID']] = $array;
                    $array = $array2;
                    break;
                }
            }

            foreach ($array AS $key => $value) {
                $array[$key] += array_combine(array_keys(self::RESPONSE['AddressValidateResponse']['fields']['Address']['fields']), array_fill(0, count(self::RESPONSE['AddressValidateResponse']['fields']['Address']['fields']), null));
                $array[$key] = array_replace(self::RESPONSE['AddressValidateResponse']['fields']['Address']['fields'], $array[$key]);
                unset($array[$key]['@ID']);
            }

            return $array;
        }

        throw new AddressValidateException('Unable to find address data.');
    }
}
