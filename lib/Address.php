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
    }

    /**
     * @param string $key
     * @param mixed
     */
    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($value, self::FIELDS[$key]);
            $this->address[$key] = $value;
        }
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function toArray()
    {
        $array = $this->address;

        if (!is_null($array['Address1'])) {
            list($array['Address2'], $array['Address1']) = [$array['Address1'], $array['Address2']];
        }

        $array += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), ''));
        $array = array_replace(self::FIELDS, $array);

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
     * @param string $value
     */
    public function setID($value)
    {
        $this->setField('@ID', $value);
    }

    /**
     * @param string $value
     */
    public function setFirmName($value)
    {
        $this->setField('FirmName', $value);
    }

    /**
     * @param string $value
     */
    public function setAddress1($value)
    {
        $this->setField('Address1', $value);
    }

    /**
     * @param string $value
     */
    public function setAddress2($value)
    {
        $this->setField('Address2', $value);
    }

    /**
     * @param string $value
     */
    public function setCity($value)
    {
        $this->setField('City', $value);
    }

    /**
     * @param string $value
     */
    public function setState($value)
    {
        $this->setField('State', $value);
    }

    /**
     * @param string $value
     */
    public function setUrbanization($value)
    {
        $this->setField('Urbanization', $value);
    }

    /**
     * @param int $value
     */
    public function setZip5($value)
    {
        $this->setField('Zip5', $value);
    }

    /**
     * @param $value
     */
    public function setZip4($value)
    {
        $this->setField('Zip4', $value);
    }
}
