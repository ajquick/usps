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
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class CityStateLookup extends USPS
{
    const FIELDS = [
        'CityStateLookupRequest' => [
            'type' => 'array',
            'fields' => [
                'ZipCode' => [
                    'type' => 'group',
                    'fields' => ZipCode::FIELDS
                ]
            ]
        ]
    ];
    const RESPONSE = [
        'CityStateLookupResponse' => [
            'type' => 'array',
            'fields' => [
                'ZipCode' => [
                    'type' => 'group',
                    'fields' => [
                        '@ID' => [
                            'type' => 'integer',
                        ],
                        'City' => [
                            'type' => 'string',
                        ],
                        'State' => [
                            'type' => 'string',
                        ],
                        'Zip5' => [
                            'type' => 'string',
                            'pattern' => '\d{5}',
                        ]
                    ]
                ]
            ]
        ]
    ];
    private $zipCodes = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        if (is_array($config) && isset($config['ZipCode'])) {
            if (is_array($config['ZipCode'])) {
                foreach ($config['ZipCode'] as $zipCodeObject) {
                    if (is_object($zipCodeObject) && $zipCodeObject instanceof ZipCode) {
                        $this->addZipCode($zipCodeObject);
                    }
                }
            } elseif (is_object($config['ZipCode']) && $config['ZipCode'] instanceof ZipCode) {
                $this->addZipCode($config['ZipCode']);
            }
        }

        $this->apiClass = 'CityStateLookup';
        $this->apiMethod = 'CityStateLookupRequest';
    }

    /**
     * @param \Multidimensional\Usps\ZipCode $zipCode
     * @throws Exception
     */
    public function addZipCode(ZipCode $zipCode)
    {
        if (count($this->zipCodes) < 5) {
            $this->zipCodes[] = $zipCode->toArray();
        } else {
            throw new Exception('Zip code not added. You can only have a maximum of 5 zip codes included in each look up request.');
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function lookup()
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

        if (is_array($this->zipCodes) && count($this->zipCodes)) {
            $array['CityStateLookupRequest']['ZipCode'] = $this->zipCodes;
        }

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

        if (is_array($array) && count($array) && (isset($array['ZipCode']) || array_key_exists('ZipCode', $array))) {
            $array = $array['ZipCode'];

            foreach ($array as $key => $value) {
                if (is_int($key)) {
                    $array[$value['@ID']] = $value;
                    unset($array[$key]);
                } else {
                    $array2 = [];
                    $array2[$array['@ID']] = $array;
                    $array = $array2;
                    unset($array2);
                    break;
                }
            }

            foreach ($array as $key => $value) {
                $array[$key] += array_combine(array_keys(self::RESPONSE['CityStateLookupResponse']['fields']['ZipCode']['fields']), array_fill(0, count(self::RESPONSE['CityStateLookupResponse']['fields']['ZipCode']['fields']), null));
                $array[$key] = array_replace(self::RESPONSE['CityStateLookupResponse']['fields']['ZipCode']['fields'], $array[$key]);
                unset($array[$key]['@ID']);
            }

            return $array;
        }

        throw new Exception();
    }
}
