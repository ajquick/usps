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
use Multidimensional\USPS\Exception\RateException;
use Multidimensional\USPS\Exception\USPSException;
use Multidimensional\USPS\Rate\Package;

class Rate extends USPS
{
    protected $packages = [];

    protected $revision = 2;

    const FIELDS = [
        'RateV4Request' => [
            'type' => 'array',
            'fields' => [
                'Revision' => [
                    'type' => 'integer',
                    'values' => [2]
                ],
                'Package' => [
                    'type' => 'group',
                    'fields' => Package::FIELDS
                ]
            ]
        ]
    ];

    const RESPONSE = [
        'RateV4Response' => [
            'type' => 'array',
            'fields' => [
                'Package' => [
                    'type' => 'group',
                    'fields' => [
                        '@ID' => [
                            'type' => 'string',
                            'required' => true
                        ],
                        'ZipOrigination' => [
                            'type' => 'string',
                            'required' => true,
                            'pattern' => '\d{5}'
                        ],
                        'ZipDestination' => [
                            'type' => 'string',
                            'required' => true,
                            'pattern' => '\d{5}'
                        ],
                        'Pounds' => [
                            'type' => 'decimal',
                            'required' => true,
                        ],
                        'Ounces' => [
                            'type' => 'decimal',
                            'required' => true,
                        ],
                        'FirstClassMailType' => [
                            'type' => 'string'
                        ],
                        'Container' => [
                            'type' => 'string',
                        ],
                        'Size' => [
                            'type' => 'string',
                            'required' => true,
                            'values' => [
                                Package::SIZE_REGULAR,
                                Package::SIZE_LARGE
                            ]
                        ],
                        'Width' => [
                            'type' => 'decimal'
                        ],
                        'Length' => [
                            'type' => 'decimal'
                        ],
                        'Height' => [
                            'type' => 'decimal'
                        ],
                        'Girth' => [
                            'type' => 'decimal'
                        ],
                        'Machinable' => [
                            'type' => 'boolean'
                        ],
                        'Zone' => [
                            'type' => 'string'
                        ],
                        'Postage' => [
                            'type' => 'group',
                            'required' => true,
                            'fields' => [
                                '@CLASSID' => [
                                    'type' => 'integer'
                                ],
                                'MailService' => [
                                    'type' => 'string'
                                ],
                                'Rate' => [
                                    'type' => 'decimal'
                                ],
                                'CommercialRate' => [
                                    'type' => 'decimal'
                                ],
                                'CommercialPlusRate' => [
                                    'type' => 'decimal'
                                ],
                                'ServiceInformation' => [
                                    'type' => 'string'
                                ],
                                'MaxDimensions' => [
                                    'type' => 'string'
                                ],
                                'PEMSH' => [
                                    'type' => 'array',
                                    'fields' => [

                                    ]
                                ],
                                'HFP' => [
                                    'type' => 'array',
                                    'fields' => [

                                    ]
                                ],
                                'SpecialServices' => [
                                    'type' => 'group',
                                    'fields' => [
                                        'SpecialService' => [
                                            'type' => 'group',
                                            'fields' => [
                                                'ServiceID' => [
                                                    'type' => 'integer'
                                                ],
                                                'ServiceName' => [
                                                    'type' => 'string'
                                                ],
                                                'Available' => [
                                                    'type' => 'boolean'
                                                ],
                                                'AvailableOnline' => [
                                                    'type' => 'boolean'
                                                ],
                                                'Price' => [
                                                    'type' => 'decimal'
                                                ],
                                                'PriceOnline' => [
                                                    'type' => 'decimal'
                                                ],
                                                'DeclaredValueRequired' => [
                                                    'type' => 'boolean'
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                'Restrictions' => [
                                    'type' => 'string'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        if (isset($config['revision'])) {
            $this->setRevision($config['revision']);
        }

        if (is_array($config) && isset($config['Package'])) {
            if (is_array($config['Package'])) {
                foreach ($config['Package'] as $packageObject) {
                    if(is_object($packageObject) && $packageObject instanceof Package) {
                        $this->addPackage($packageObject);
                    }
                }
            } elseif(is_object($config['Package']) && $config['Package'] instanceof Package) {
                $this->addPackage($config['Package']);
            }
        }

        $this->apiClass = 'RateV4';
        $this->apiMethod = 'RateV4Request';
    }

    /**
     * @return string
     */
    public function getRate()
    {
        try {
            $xml = $this->buildXML($this->toArray());
            if ($this->validateXML($xml)) {
                $result = $this->request($xml);
                return $this->parseResult($result);
            } else {
                throw new RateException('Unable to validate XML.');
            }
        } catch (ValidationException $e) {
            throw new RateException($e->getMessage());
        }
    }

    /**
     * @param Package $package
     */
    public function addPackage(Package $package)
    {
        if (count($this->packages) < 25) {
            $this->packages[] = $package->toArray();
        } else {
            throw new RateException('Package not added. You can only have a maximum of 25 packages included in each look up request.');
        }
    }

    /**
     * @param $value
     */
    public function setRevision($value)
    {
        if (intval($value) === 2) {
            $this->revision = 2;
        } else {
            $this->revision = null;
        }
    }

    /**
     * @return array|null
     * @throws RateException
     */
    public function toArray()
    {
        $array = [];

        if ($this->revision === 2) {
            $array['RateV4Request']['Revision'] = 2;
        }

        if (is_array($this->packages) && count($this->packages)) {
            $array['RateV4Request']['Package'] = $this->packages;
        }

        try {
            if (is_array($array) && count($array)) {
                Validation::validate($array, self::FIELDS);
            } else {
                return null;
            }
        } catch (ValidationException $e) {
            throw new RateException($e->getMessage());
        }

        return $array;
    }

    /**
     * @param string $result
     * @return array
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
            throw new RateException($e->getMessage());
        }

        $array = $array['RateV4Response'];

        if (is_array($array) && count($array) && (isset($array['Package']) || array_key_exists('Package', $array) )) {

            $array = $array['Package'];
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
                $array[$key] += array_combine(array_keys(self::RESPONSE['RateV4Response']['fields']['Package']['fields']), array_fill(0, count(self::RESPONSE['RateV4Response']['fields']['Package']['fields']), null));
                $array[$key] = array_replace(self::RESPONSE['RateV4Response']['fields']['Package']['fields'], $array[$key]);
                unset($array[$key]['@ID']);
            }

            return $array;

        } else {
            throw new RateException();
        }
    }
}
