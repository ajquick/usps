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

class Validation
{
    public $error = false;
    public $errorMessage = null;
    
    /**
     * @param array $array
     * @param array $rules
     * @return bool
     */  
    public function validate($array, $rules)
    {
        if (is_array($array)) {
            foreach ($array AS $key => $value) {    
                if (!isset($rules[$key]) || $this->validateField($value, $rules[$key], $key) !== true) {
                    return false;
                }            
            }
            
            if (!$this->checkRequired($array, $rules)) {
                return false;            
            }
        }
        
        return true;     
    }
    
    /**
     * @param string $key
     * @param string $value
     * @param array $rules
     * @return bool
     */
    public function validateField($value, $rules, $key = null)
    {
        if(is_array($value) && isset($rules['fields'])) {
            return $this->validate($value, $rules['fields']);
        } elseif (is_array($value)) {
            $this->setError(sprintf("Unexpected array found for key %s.", $key));
            return false;
        }
        
        if (isset($rules['type'])) {
            if ($rules['type'] === 'integer') {
                if ($value != (int) $value) {
                    $this->setError(sprintf("Invalid integer %s != %s for key %s.", $value, (int) $value, $key));
                    return false;    
                }
            } elseif ($rules['type'] === 'decimal') {
                if ($value != (float) $value) {
                    $this->setError(sprintf("Invalid decimal %s != %s for key %s.", $value, (float) $value, $key));
                    return false;    
                }
            } elseif ($rules['type'] === 'string') {
                if ($value != (string) $value) {
                    $this->setError(sprintf("Invalid string %s != %s for key %s.", $value, (string) $value, $key));
                    return false;    
                }
            } elseif ($rules['type'] === 'boolean') {
                if ($value != (bool) $value) {
                    $this->setError(sprintf("Invalid boolean %s != %s for key %s.", $value, (bool) $value, $key));
                    return false;    
                }
            }                
        }
        
        if (isset($rules['pattern'])) {
            if (!preg_match('/^' . $rules['pattern'] . '$/', $value)) {
                $this->setError(sprintf("Invalid value %s does not match pattern '%s' for key %s.", $value, $rules['pattern'], $key));
                return false;    
            }
        }
        
        return true;
    }
    
    /**
     * @param array $array
     * @param array $rules
     * @return bool
     */
    public function checkRequired($array, $rules) {
        
        foreach ($rules AS $key => $value) {
            if (isset($value['required']) && !isset($array[$key])) {
                $failure = true;
                if (is_array($value['required'])) {
                    foreach ($value['required'] AS $key2 => $value2) {
                        if (is_array($value)) {
                            foreach ($value2 AS $key3 => $value3) {
                                
                            }
                        } else {
                            if ($value2 === null || $value2 == 'null') {
								if (!isset($array[$key2]) && $array[$key2] !== null && $array[$key2] != 'null') {
									$failure = false;
								}
							} else {
								if (!isset($array[$key2]) && $array[$key2] != $value2) {
									$failure = false;	
								}
							}.
                        }
                    }
                } elseif ($value['required'] === true || $value['required'] == 'true') {
                    if (!isset($array[$key])) {
                        return false;
                    }else{
                        $failure = false;    
                    }
                }
                if ($failure === true) {
                    return false;    
                }
            }
        }
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function isSuccess()
    {
        if ($this->error) {
            return false;
        }else{
            return true;    
        }
    }
    
    /**
     * @return bool
     */
    public function isError()
    {
        return (bool) $this->error;    
    }
    
    /**
     * @return null|string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
    
    /**
     * @param string $message
     * @return void
     */
    private function setError($message)
    {
        $this->error = true;
        $this->errorMessage = $message;
        return;
    }
}
