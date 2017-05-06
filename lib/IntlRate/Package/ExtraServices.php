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

namespace Multidimensional\USPS\IntlRate\Package;

use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Exception\ValidationException;
use Multidimensional\ArrayValidation\Validation;
use Multidimensional\USPS\IntlRate\Package\Exception\ExtraServicesException;

class ExtraServices
{
    /**
     * @var $services
     */
    protected $service = [];

    const REGISTERED_MAIL = 0;
    const INSURANCE = 1;
    const RETURN_RECEIPT = 2;
    const CERTIFICATE_OF_MAILING = 6;
    const ELECTRONIC_DELIVERY_CONFIRMATION = 9;

    const FIELDS = [
        'ExtraService' => [
            'type' => 'integer',
            'values' => [
                self::REGISTERED_MAIL,
                self::INSURANCE,
                self::RETURN_RECEIPT,
                self::CERTIFICATE_OF_MAILING,
                self::ELECTRONIC_DELIVERY_CONFIRMATION
            ]
        ]
    ];
    
    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                if ($key == 'ExtraService' || in_array($value, self::FIELDS['ExtraServices']['values'])) {
                    $this->addService($value);
                }
            }
        }

        return;
    }

    /**
     * @return array|null
     * @throws ExtraServicesException
     */
    public function toArray()
    {
        
        try {
            if (is_array($this->service) && count($this->service)) {
                Validation::validate($this->service, self::FIELDS);
            } else {
                return null;
            }
        } catch (ValidationException $e) {
            throw new ExtraServicesException($e->getMessage());
        }

        return $this->service;
    }
    
    /**
     * @param string|int $value
     * @return void
     */
    public function addService($value)
    {
        $value = Sanitization::sanitizeField($value, self::FIELDS['ExtraService']);
        $this->service['ExtraService'] = $value;
        
        return;
    }
}
