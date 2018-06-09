<?php
/**
 *     __  ___      ____  _     ___                           _                    __
 *    /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *   / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *  / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 * /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * @author Multidimension.al
 * @copyright Copyright © 2016-2018 Multidimension.al - All Rights Reserved
 * @license Proprietary and Confidential
 *
 * NOTICE:  All information contained herein is, and remains the property of
 * Multidimension.al and its suppliers, if any.  The intellectual and
 * technical concepts contained herein are proprietary to Multidimension.al
 * and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law. Dissemination
 * of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained.
 */

namespace Multidimensional\USPS\IntlRate\Package;

use Exception;
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class ExtraServices
{
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
    /**
     * @var $services
     */
    protected $service = [];

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
     * @param string|int $value
     * @return void
     */
    public function addService($value)
    {
        $value = Sanitization::sanitizeField($value, self::FIELDS['ExtraService']);
        $this->service['ExtraService'] = $value;

        return;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function toArray()
    {

        try {
            if (is_array($this->service) && count($this->service)) {
                Validation::validate($this->service, self::FIELDS);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $this->service;
    }
}
