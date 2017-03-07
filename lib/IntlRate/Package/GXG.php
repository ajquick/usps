<?php
/**
 *     __  ___      ____  _     ___                           _                    __
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

namespace Multidimensional\Usps\IntlRate\Package;

use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class GXG
{
    protected $gxg = [];
    protected $validation;
    
    const POBOXFLAG_YES = 'Y';
    const POBOXFLAG_NO = 'N';
    const GIFTFLAG_YES = 'Y';
    const GIFTFLAG_NO = 'N';

    const FIELDS = [
        'POBoxFlag' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                'Y',
                'N'
            ]
        ],
        'GiftFlag' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                'Y',
                'N'
            ]
        ]
    ];

    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                $this->setField($key, $value);
            }
        }
        
        $this->gxg += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), null));
        
        $this->validation = new Validation();
        
        return;
    }
    
    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($key, $value, self::FIELDS[$key]);
            $this->gxg[$key] = $value;
        }
        
        return;
    }
    
    public function toArray()
    {
        if ($this->validation->validate($this->gxg, self::FIELDS)) {
            return $this->gxg;
        }
        
        return null;
    }
    
    public function setGiftFlag($value)
    {
        $this->setField('GiftFlag', $value);
    }
    
    public function setPOBoxFlag($value)
    {
        $this->setField('POBoxFlag', $value);
    }
}
