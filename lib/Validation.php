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

class Validation
{
    public function __construct(array $config = []) 
    {
        
    }
    
    public function validate($array, $rules)
    {
        
        if (count($array)) {
            foreach ($array AS $key => $value) {    
                if ($this->validateField($key, $value, $rules[$key]) !== true) {
                    return false;
                }
            }
        }
            
    }
    
    /**
     * @param string $key
     * @param string $value
     * @param array $rules
     */
    public function validateField($key, $value, $rules)
    {
        
        if (isset($rules['pattern'])) {
            if (!preg_match('/^' . $rules['pattern'] . '$/', $value)) {
                return false;    
            }
        }
        
        return true;
        
    }
}
