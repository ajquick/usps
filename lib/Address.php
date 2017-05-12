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

class Address
{
    /**
     * @var array $fields
     */
    const FIELDS = [
        '@ID' => [
            'type' => 'integer',
            'required' => true
        ],
        'FirmName' => [
            'type' => 'string'
        ],
        'Address1' => [
            'type' => 'string',
        ],
        'Address2' => [
            'type' => 'string',
            'required' => true
        ],
        'City' => [
            'type' => 'string',
            'required' => [
                'Zip5' => null
            ]
        ],
        'State' => [
            'type' => 'string',
            'required' => [
                'Zip5' => null
            ],
            'pattern' => '[A-Z]{2}'
        ],
        'Urbanization' => [
            'type' => 'string'
        ],
        'Zip5' => [
            'type' => 'string',
            'required' => [
                [
                    'City' => null,
                    'State' => null
                ]
            ],
            'pattern' => '\d{5}'
        ],
        'Zip4' => [
            'type' => 'string',
            'pattern' => '\d{4}'
        ]
    ];
    /**
     * @var array $address
     */
    public $address = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            if (isset($config['ID'])) {
                $config['@ID'] = $config['ID'];
                unset($config['ID']);
            }
            foreach ($config as $key => $value) {
                $this->setField($key, $value);
            }
        }
        $this->address += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), null));

        return;
    }

    /**
     * @param string $key
     * @param mixed
     * @return void
     */
    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($value, self::FIELDS[$key]);
            $this->address[$key] = $value;
        }

        return;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function toArray()
    {
        $array = $this->address;
        list($array['Address2'], $array['Address1']) = [$array['Address1'], $array['Address2']];

        try {
            if (is_array($array) && count($array)) {
                Validation::validate($array, self::FIELDS);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }

        $array = array_replace(self::FIELDS, $array);

        return $array;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setID($value)
    {
        $this->setField('@ID', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setFirmName($value)
    {
        $this->setField('FirmName', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setAddress1($value)
    {
        $this->setField('Address1', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setAddress2($value)
    {
        $this->setField('Address2', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setCity($value)
    {
        $this->setField('City', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setState($value)
    {
        $this->setField('State', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setUrbanization($value)
    {
        $this->setField('Urbanization', $value);

        return;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setZip5($value)
    {
        $this->setField('Zip5', $value);

        return;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setZip4($value)
    {
        $this->setField('Zip4', $value);

        return;
    }
}
