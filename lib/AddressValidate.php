<?php
/**
 *       __  ___      ____  _     ___                           _                    __
 *      /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *     / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *    / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *   /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 *  USPS API PHP Library
 *  Copyright (c) Multidimension.al (http://multidimension.al)
 *  Github : https://github.com/multidimension-al/usps
 *
 *  Licensed under The MIT License
 *  For full copyright and license information, please see the LICENSE file
 *  Redistributions of files must retain the above copyright notice.
 *
 *  @copyright  Copyright © 2017-2019 Multidimension.al (http://multidimension.al)
 *  @link       https://github.com/multidimension-al/usps Github
 *  @license    http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\USPS;

use Exception;
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class AddressValidate extends USPS
{
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
    protected $addresses = [];
    protected $includeOptionalElements = false;
    protected $returnCarrierRoute = false;

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
                    if (is_object($addressObject) && $addressObject instanceof Address) {
                        $this->addAddress($addressObject);
                    }
                }
            } elseif (is_object($config['Address']) && $config['Address'] instanceof Address) {
                $this->addAddress($config['Address']);
            }
        }

        $this->apiClass = 'Verify';
        $this->apiMethod = 'AddressValidateRequest';
    }

    /**
     * @param bool $boolean
     * @return void
     */
    public function setIncludeOptionalElements($boolean)
    {
        $this->includeOptionalElements = (bool)$boolean;
    }

    /**
     * @param bool $boolean
     * @return void
     */
    public function setReturnCarrierRoute($boolean)
    {
        $this->returnCarrierRoute = (bool)$boolean;
    }

    /**
     * @param \Multidimensional\Usps\Address $address
     * @throws Exception
     */
    public function addAddress(Address $address)
    {
        if (count($this->addresses) < 5) {
            $this->addresses[] = $address->toArray();
        } else {
            throw new Exception('Address not added. You can only have a maximum of 5 addresses included in each look up request.');
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function validate()
    {
        try {
            $xml = $this->buildXML($this->toArray());
            if ($this->validateXML($xml)) {
                $result = $this->request($xml);
                return $this->parseResult($result);
            } else {
                throw new Exception('Unable to validate XML.');
            }
        } catch (Exception $e) {
            throw $e;
        }
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
        } catch (Exception $e) {
            throw $e;
        }

        return $array;
    }

    /**
     * @param string $result
     * @return array
     * @throws Exception
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
        } catch (Exception $e) {
            throw $e;
        }

        $array = $array['AddressValidateResponse'];

        if (is_array($array) && count($array) && (isset($array['Address']) || array_key_exists('Address', $array))) {
            $array = $array['Address'];

            foreach ($array as $key => $value) {
                if (is_int($key)) {
                    list($array[$key]['Address2'], $array[$key]['Address1']) = [isset($value['Address1']) ? $value['Address1'] : null, isset($value['Address2']) ? $value['Address2'] : null];
                } else {
                    list($array['Address2'], $array['Address1']) = [isset($array['Address1']) ? $array['Address1'] : null, isset($array['Address2']) ? $array['Address2'] : null];
                    break;
                }
            }

            foreach ($array as $key => $value) {
                if (is_int($key)) {
                    $array[$value['@ID']] = $value;
                    unset($array[$key]);
                } else {
                    $array2[$array['@ID']] = $array;
                    $array = $array2;
                    break;
                }
            }

            foreach ($array as $key => $value) {
                $array[$key] += array_combine(array_keys(self::RESPONSE['AddressValidateResponse']['fields']['Address']['fields']), array_fill(0, count(self::RESPONSE['AddressValidateResponse']['fields']['Address']['fields']), null));
                $array[$key] = array_replace(self::RESPONSE['AddressValidateResponse']['fields']['Address']['fields'], $array[$key]);
                unset($array[$key]['@ID']);
            }

            return $array;
        }

        throw new Exception('Unable to find address data.');
    }
}
