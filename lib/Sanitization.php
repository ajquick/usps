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
        $newArray = [];
        if (count($array)) {
            foreach ($array AS $key => $value) {    
                if (in_array($key, array_keys($rules))) {
                    $newArray[$key] = $this->sanitizeField($key, $value, $rules[$key]);
                }
            }
        }
        
        return $newArray;
    }
    
    /**
     * @param string $key
     * @param string $value
     * @param array $rules
     */
    public function sanitizeField($key, $value, $rules)
    {
        if (is_array($value)) {    
            return $this->sanitize($value, $rules);    
        }
                    
        if (isset($rules['type']) && in_array($rules['type'], $this->typeArray)) {
            $value = $this->{sanitize.ucwords($rules['type'])}($value);            
        }
        
        if (isset($rules['pattern'])) {
			
			if ($rules['pattern'] == 'ISO 8601') {
				$rules['pattern'] = '([\+-]?\d{4}(?!\d{2}\b))((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?';
			}
			
            $value = preg_replace("/[^" . $rules['pattern'] . "]/", "", $value);
        }
        
        
        return $value;
    }
    
    /**
     * @param string|int $value
     * @return int
     */
    private function sanitizeInteger($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
    
    /**
     * @param string $value
     * @return string
     */
    private function sanitizeString($value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }
    
    /**
     * @param string|float $value
     * @return float
     */
    private function sanitizeDecimal($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * @param string|bool $value
     * @return true|false|null
     */
    private function sanitizeBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
    
}