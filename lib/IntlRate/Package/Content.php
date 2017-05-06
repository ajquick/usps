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
use Multidimensional\USPS\IntlRate\Package\Exception\ContentException;

class Content
{
    protected $content = [];

    const TYPE_CREMATED_REMAINS = 'CrematedRemains';
    const TYPE_NONNEGOTIABLE_DOCUMENT = 'NonnegotiableDocument';
    const TYPE_PHARMACEUTICALS = 'Pharmaceuticals';
    const TYPE_MEDICAL_SUPPLIES = 'MedicalSupplies';
    const TYPE_DOCUMENTS = 'Documents';

    const FIELDS = [
        'ContentType' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                self::TYPE_CREMATED_REMAINS,
                self::TYPE_NONNEGOTIABLE_DOCUMENT,
                self::TYPE_PHARMACEUTICALS,
                self::TYPE_MEDICAL_SUPPLIES,
                self::TYPE_DOCUMENTS
            ]
        ],
        'ContentDescription' => [
            'type' => 'string'
        ]
    ];
    
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
     * @throws ContentException
     */
    public function toArray()
    {
        try {
            if (is_array($this->content) && count($this->content)) {
                Validation::validate($this->content, self::FIELDS);
            } else {
                return null;
            }
        } catch (ValidationException $e) {
            throw new ContentException($e->getMessage());
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
