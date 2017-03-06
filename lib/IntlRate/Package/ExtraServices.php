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

class ExtraServices
{
    private $validation;

    /**
     * @var $services
     */
    public $service = [];

    const REGISTERED_MAIL = 0;
    const INSURANCE = 1;
    const RETURN_RECEIPT = 2;
    const CERTIFICATE_OF_MAILING = 6;
    const ELECTRONIC_DELIVERY_CONFIRMATION = 9;

    const FIELDS = [
        'ExtraService' => [
            'type' => 'integer',
            'values' => [
                0,
                1,
                2,
                6,
                9
            ]
        ]
    ];
    
    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            foreach ($config as $value) {
                $this->addService($value);
            }
        }
        
        $this->validation = new Validation();
        
        return;
    }
    
    /**
     * @return array|null
     */
    public function toArray()
    {
        if ($this->validation->validate($this->service, self::FIELDS)) {
            return $this->service;
        }
        
        return null;
    }
    
    /**
     * @param string|int $value
     * @return void
     */
    public function addService($value)
    {
        $value = Sanitization::sanitizeField('ExtraService', $value, self::FIELDS['ExtraService']);
        $this->services['ExtraService'] = $value;
        
        return;
    }
}
