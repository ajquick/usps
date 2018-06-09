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

namespace Multidimensional\USPS\Rate\Package;

use Exception;
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class Content
{
    const TYPE_HAZMAT = 'HAZMAT';
    const TYPE_CREMATED_REMAINS = 'CREMATEDREMAINS';
    const TYPE_LIVES = 'LIVES';
    const DESCRIPTION_BEES = 'BEES';
    const DESCRIPTION_DAY_OLD_POULTRY = 'DAYOLDPOULTRY';
    const DESCRIPTION_ADULT_BIRDS = 'ADULTBIRDS';
    const DESCRIPTION_OTHER = 'OTHER';
    const FIELDS = [
        'ContentType' => [
            'type' => 'string',
            'values' => [
                self::TYPE_HAZMAT,
                self::TYPE_CREMATED_REMAINS,
                self::TYPE_LIVES
            ]
        ],
        'ContentDescription' => [
            'type' => 'string',
            'required' => [
                'ContentType' => self::TYPE_LIVES
            ],
            'values' => [
                self::DESCRIPTION_BEES,
                self::DESCRIPTION_DAY_OLD_POULTRY,
                self::DESCRIPTION_ADULT_BIRDS,
                self::DESCRIPTION_OTHER
            ]
        ]
    ];
    protected $content = [];

    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                $this->setField($key, $value);
            }
        }

        $this->content += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), null));

        return;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($value, self::FIELDS[$key]);
            $this->content[$key] = $value;
        }

        return;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function toArray()
    {
        try {
            if (is_array($this->content) && count($this->content)) {
                Validation::validate($this->content, self::FIELDS);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $this->content;
    }

    /**
     * @param $value
     */
    public function setContentType($value)
    {
        $this->setField('ContentType', $value);
    }

    /**
     * @param $value
     */
    public function setContentDescription($value)
    {
        $this->setField('ContentDescription', $value);
    }
}
