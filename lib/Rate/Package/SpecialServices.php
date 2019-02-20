<?php
/**
 *       __  ___      ____  _     ___                           _                    __
 *      /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *     / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *    / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *   /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 *  USPS API PHP Library
 *  Copyright (c) Multidimension.al (http://multidimension.al)
 *  Github : https://github.com/multidimension-al/usps
 *
 *  Licensed under The MIT License
 *  For full copyright and license information, please see the LICENSE file
 *  Redistributions of files must retain the above copyright notice.
 *
 *  @copyright  Copyright © 2017-2019 Multidimension.al (http://multidimension.al)
 *  @link       https://github.com/multidimension-al/usps Github
 *  @license    http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\USPS\Rate\Package;

use Exception;
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class SpecialServices
{
    const INSURANCE = 100;
    const INSURANCE_PRIORITY_EXPRESS = 101;
    const RETURN_RECEIPT = 102;
    const COLLECT_ON_DELIVERY = 103;
    const CERTIFICATE_OF_MAILING_3665 = 104;
    const CERTIFIED_MAIL = 105;
    const USPS_TRACKING = 106;
    const RETURN_RECEIPT_MERCHANDISE = 107;
    const SIGNATURE_CONFIRMATION = 108;
    const REGISTERED_MAIL = 109;
    const RETURN_RECEIPT_ELECTRONIC = 110;
    const REGISTERED_MAIL_COLLECT_ON_DELIVERY = 112;
    const RETURN_RECEIPT_PRIORITY_EXPRESS = 118;
    const ADULT_SIGNATURE_REQUIRED = 119;
    const ADULT_SIGNATURE_RESTRICTED_DELIVERY = 120;
    const INSURANCE_PRIORITY = 125;
    const SIGNATURE_CONFIRMATION_ELECTRONIC = 156;
    const CERTIFICATE_OF_MAILING_3817 = 160;
    const PRIORITY_EXPRESS_AM_DELIVERY = 161;
    const CERTIFIED_MAIL_RESTRICTED_DELIVERY = 170;
    const CERTIFIED_MAIL_ADULT_SIGNATURE_REQUIRED = 171;
    const CERTIFIED_MAIL_ADULT_SIGNATURE_RESTRICTED_DELIVERY = 172;
    const SIGNATURE_CONFIRMATION_RESTRICTED_DELIVERY = 173;
    const SIGNATURE_CONFIRMATION_ELECTRONIC_RESTRICTED_DELIVERY = 174;
    const COLLECT_ON_DELIVERY_RESTRICTED_DELIVERY = 175;
    const REGISTERED_MAIL_RESTRICTED_DELIVERY = 176;
    const INSURANCE_RESTRICTED_DELIVERY = 177;
    const INSURANCE_RESTRICTED_DELIVERY_PRIORITY = 178;
    const INSURANCE_RESTRICTED_DELIVERY_PRIORITY_EXPRESS = 179;
    const INSURANCE_RESTRICTED_DELIVERY_BULK = 180;
    const FIELDS = [
        'SpecialService' => [
            'type' => 'integer',
            'values' => [
                self::INSURANCE,
                self::INSURANCE_PRIORITY_EXPRESS,
                self::RETURN_RECEIPT,
                self::COLLECT_ON_DELIVERY,
                self::CERTIFICATE_OF_MAILING_3665,
                self::CERTIFIED_MAIL,
                self::USPS_TRACKING,
                self::RETURN_RECEIPT_MERCHANDISE,
                self::SIGNATURE_CONFIRMATION,
                self::REGISTERED_MAIL,
                self::RETURN_RECEIPT_ELECTRONIC,
                self::REGISTERED_MAIL_COLLECT_ON_DELIVERY,
                self::RETURN_RECEIPT_PRIORITY_EXPRESS,
                self::ADULT_SIGNATURE_REQUIRED,
                self::ADULT_SIGNATURE_RESTRICTED_DELIVERY,
                self::INSURANCE_PRIORITY,
                self::SIGNATURE_CONFIRMATION_ELECTRONIC,
                self::CERTIFICATE_OF_MAILING_3817,
                self::PRIORITY_EXPRESS_AM_DELIVERY,
                self::CERTIFIED_MAIL_RESTRICTED_DELIVERY,
                self::CERTIFIED_MAIL_ADULT_SIGNATURE_REQUIRED,
                self::CERTIFIED_MAIL_ADULT_SIGNATURE_RESTRICTED_DELIVERY,
                self::SIGNATURE_CONFIRMATION_RESTRICTED_DELIVERY,
                self::SIGNATURE_CONFIRMATION_ELECTRONIC_RESTRICTED_DELIVERY,
                self::COLLECT_ON_DELIVERY_RESTRICTED_DELIVERY,
                self::REGISTERED_MAIL_RESTRICTED_DELIVERY,
                self::INSURANCE_RESTRICTED_DELIVERY,
                self::INSURANCE_RESTRICTED_DELIVERY_PRIORITY,
                self::INSURANCE_RESTRICTED_DELIVERY_PRIORITY_EXPRESS,
                self::INSURANCE_RESTRICTED_DELIVERY_BULK,
            ]
        ]
    ];
    protected $service = [];

    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                if ($key == 'SpecialService' || in_array($value, self::FIELDS['SpecialServices']['values'])) {
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
        $value = Sanitization::sanitizeField($value, self::FIELDS['SpecialService']);
        $this->service['SpecialService'] = $value;

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
