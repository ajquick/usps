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

class Sanitization
{
    
    /**
     * @var array $typeArray
     */
    public $typeArray = ['integer', 'decimal', 'string', 'boolean'];
    
    /**
     * @param array $config
     * @return void
     */
    public function __construct(array $config = []) 
    {
        
    }
    
    /**
     * @param array $array
     * @param array $rules
     * @return array
     */
    public function sanitize($array, $rules)
    {
        $new_array = [];
        if (count($array)) {
            foreach ($array AS $key => $value) {    
                if (in_array($key, array_keys($rules))) {
                    $new_array[$key] = $this->sanitizeField($key, $value, $rules[$key]);
                }
            }
        }
        
        return $new_array;
    }
    
    /**
     * @param string $key
     * @param string $value
     * @param array $rules
     */
    public function sanitizeField($key, $value, $rules)
    {
        if (isset($rules['type']) && in_array($rules['type'], $this->typeArray)) {
            $value = $this->{_sanitize.ucwords($rules['type'])}($value);            
        } else if (isset($rules['type'])) {
            //Function for 'object' types    
        }
        
        if (isset($rules['pattern'])) {
            //preg_replace
        }
        
        return $value;
    }
    
    /**
     * @param string|int $value
     * @return int
     */
    private function _sanitizeInteger($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
    
    /**
     * @param string $value
     * @return string
     */
    private function _sanitizeString($value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }
    
    /**
     * @param string|float $value
     * @return float
     */
    private function _sanitizeDecimal($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * @param string|bool $value
     * @return true|false|null
     */
    private function _sanitizeBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
    
}