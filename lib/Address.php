<?php
/**    __  ___      ____  _     ___                           _                    __
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

use Multidimensional\Usps\Sanitization;

class Address
{

    /**
     * @var array $address
     */
    public $address = [];

    /**
     * @var array $fields
     */
    public $fields = [
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
            'type' => 'integer',
            'required' => [
                [
                    'City' => null,
                    'State' => null
                ]
            ],
            'pattern' => 'd{5}'
        ],
        'Zip4' => [
            'type' => 'integer',
            'pattern' => 'd{4}'
        ]
    ];
    
    /**
     * @param array $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            foreach ($config AS $key => $value) {
                $this->setField($key, $value);
            }
        }
        $this->address += array_combine(array_keys($this->fields), array_fill(0, count($this->fields), null));
    }
    
    /**
     * @param string $key
     * @param int|bool|string|float
     * @return void
     */
     public function setField($key, $value) 
     { 
        if (in_array($key, array_keys($this->fields))) {
            $value = (new Sanitization)->sanitizeField($key, $value, $this->fields[$key]);
            $this->address[$key] = $value;
        }
     }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->address;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setID($value)
    {
        $this->setField('@ID', $value);    
    }

    /**
     * @param string $value
     * @return void
     */
    public function setFirmName($value)
    {
        $this->setField('FirmName', $value);    
    }
    
    /**
     * @param string $value
     * @return void
     */    
    public function setAddress1($value)
    {
        $this->setField('Address1', $value);    
    }
    
    /**
     * @param string $value
     * @return void
     */    
    public function setAddress2($value)
    {
        $this->setField('Address2', $value);    
    }

    /**
     * @param string $value
     * @return void
     */    
    public function setCity($value)
    {
        $this->setField('City', $value);    
    }

    /**
     * @param string $value
     * @return void
     */    
    public function setState($value)
    {
        $this->setField('State', $value);    
    }

    /**
     * @param string $value
     * @return void
     */    
    public function setUrbanization($value)
    {
        $this->setField('Urbanization', $value);    
    }

    /**
     * @param int $value
     * @return void
     */    
    public function setZip5($value)
    {
        $this->setField('Zip5', $value);    
    }

    /**
     * @param int $value
     * @return void
     */    
    public function setZip4($value)
    {
        $this->setField('Zip4', $value);    
    }
}
