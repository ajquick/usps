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

namespace Multidimensional\Usps;

use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class ZipCode
{

    protected $validation;
    protected $zipCode = [];

    const FIELDS = [
        '@ID' => [
            'type' => 'integer',
            'required' => true
        ],
        'Zip5' => [
            'type' => 'integer',
            'required' => true,
            'pattern' => '\d{5}'
        ]
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                $this->setField($key, $value);
            }
        }
        $this->zipCode += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), null));
        
        $this->validation = new Validation();
        
        return;
    }
    
    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setField($key, $value)
    {
        if (self::FIELDS[$key] !== null || array_key_exists($key, self::FIELDS)) {
            if (Sanitization::sanitizeField($value, self::FIELDS[$key])) {
                $this->zipCode[$key] = $value;
            }
        }
        
        return;
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
     * @param int $value
     * @return void
     */
    public function setZip5($value)
    {
        $this->setField('Zip5', $value);
        
        return;
    }
    
    /**
     * @param string $key
     * @return void
     */
    public function deleteField($key)
    {
        unset($this->zipCode[$key]);
        
        return;
    }
    
    /**
     * @return array|null
     */
    public function toArray()
    {
        try {
            if ($this->validation->validate($this->zipCode, self::FIELDS)) {
                return $this->zipCode;
            }
        } catch (ValidationException $e) {
        }
        
        return null;
    }
}
