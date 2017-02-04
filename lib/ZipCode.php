<?php
/**
 * CONFIDENTIAL
 *
 * © 2017 Multidimension.al - All Rights Reserved
 * 
 * NOTICE:  All information contained herein is, and remains
 * the property of Multidimension.al and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to Multidimension.al and its suppliers
 * and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained.
 */

namespace Multidimensional\Usps;

class ZipCode
{

    protected $zipCode = [];

    public $fields = [
        '@ID' => [
            'type' => 'integer',
            'required' => true
        ],
        'Zip5' => [
            'type' => 'integer',
            'required' => true
            'pattern' => 'd{5}'
        ]
    ];
    
    public function __construct(array $config = [])
    {
        if (count($config)) {
            foreach ($config AS $key => $value) {
                $this->setField($key, $value);
            }
        }
        
    }
    
    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setField($key, $value)
    {
        if(isset($this->fields[$key]) || array_key_exists($key, $this->fields)){
            
            if (Validation->validateField($key, $value, $this->fields[$key])) {
                $this->zipCode[$key] = $value;
            }
        }    
    }
    
    /**
     * @param string $key
     * @return void
     */
    public function deleteField($key)
    {
        unset($this->zipCode[$key]);
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->zipCode;
    }
    
}
