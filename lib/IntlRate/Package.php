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

namespace Multidimensional\USPS\IntlRate;

use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Exception\ValidationException;
use Multidimensional\ArrayValidation\Validation;
use Multidimensional\USPS\IntlRate\Exception\PackageException;
use Multidimensional\USPS\IntlRate\Package\Content;
use Multidimensional\USPS\IntlRate\Package\ExtraServices;
use Multidimensional\USPS\IntlRate\Package\GXG;

class Package
{
    protected $package = [];
    protected $content;
    protected $extraServices = [];
    protected $gxg;
    
    const CONTAINER_RECTANGULAR = 'RECTANGULAR';
    const CONTAINER_NONRECTANGULAR  = 'NONRECTANGULAR';
    const MAIL_TYPE_ALL = 'ALL';
    const MAIL_TYPE_PACKAGE = 'PACKAGE';
    const MAIL_TYPE_POSTCARDS   = 'POSTCARDS';
    const MAIL_TYPE_ENVELOPE = 'ENVELOPE';
    const MAIL_TYPE_LETTER  = 'LETTER';
    const MAIL_TYPE_LARGEENVELOPE   = 'LARGEENVELOPE';
    const MAIL_TYPE_FLATRATE = 'FLATRATE';
    const SIZE_LARGE = 'LARGE';
    const SIZE_REGULAR  = 'REGULAR';

    const FIELDS = [
        '@ID' => [
            'type' => 'string'
        ],
        'Pounds' => [
            'type' => 'decimal',
            'required' => true
        ],
        'Ounces' => [
            'type' => 'decimal',
            'required' => true
        ],
        'Machinable' => [
            'type' => 'boolean',
            'default' => true
        ],
        'MailType' => [
            'type' => 'string',
            'required' => true
        ],
        'GXG' => [
            'type' => 'array',
            'fields' => GXG::FIELDS
        ],
        'ValueOfContents' => [
            'type' => 'string',
            'required' => true
        ],
        'Country' => [
            'type' => 'string',
            'required' => true
        ],
        'Container' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                self::CONTAINER_RECTANGULAR,
                self::CONTAINER_NONRECTANGULAR
            ]
        ],
        'Size' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                self::SIZE_REGULAR,
                self::SIZE_LARGE
            ]
        ],
        'Width' => [
            'type' => 'integer',
            'required' => [
                'Size' => self::SIZE_LARGE
            ]
        ],
        'Length' => [
            'type' => 'integer',
            'required' => [
                'Size' => self::SIZE_LARGE
            ]
        ],
        'Height' => [
            'type' => 'integer',
            'required' => [
                'Size' => self::SIZE_LARGE
            ]
        ],
        'Girth' => [
            'type' => 'integer',
            'required' => [
                [
                    'Size' => self::SIZE_LARGE,
                    'Container' => self::CONTAINER_NONRECTANGULAR
                ]
            ]
        ],
        'OriginZip' => [
            'type' => 'integer',
            'required' => [
                'Country' => 'Canada'
            ],
            'pattern' => '\d{5}'
        ],
        'CommercialFlag' => [
            'type' => 'string',
            'values' => [
                'Y',
                'N'
            ]
        ],
        'CommercialPlusFlag' => [
            'type' => 'string',
            'values' => [
                'Y',
                'N'
            ]
        ],
        'ExtraServices' => [
            'type' => 'group',
            'fields' => ExtraServices::FIELDS
        ],
        'AcceptanceDateTime' => [
            'type' => 'datetime',
            'pattern' => 'ISO 8601'
        ],
        'DestinationPostalCode' => [
            'type' => 'string'
        ],
        'Content' => [
            'type' => 'array',
            'fields' => Content::FIELDS
        ]
    ];

    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            if (isset($config['ID'])) {
                $config['@ID'] = $config['ID'];
                unset($config['ID']);
            }
            foreach ($config as $key => $value) {
                $this->setField($key, $value);
            }
        }
        
        $this->package += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), null));

        return;
    }
    
    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($value, self::FIELDS[$key]);
            $this->package[$key] = $value;
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
     * @param string $value
     * @return void
     */
    public function setPounds($value)
    {
        $this->setField('Pounds', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setOunces($value)
    {
        $this->setField('Ounces', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setMachinable($value)
    {
        $this->setField('Machinable', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setMailType($value)
    {
        $this->setField('MailType', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setValueOfContents($value)
    {
        $this->setField('ValueOfContents', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setCountry($value)
    {
        $this->setField('Country', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setContainer($value)
    {
        $this->setField('Container', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setSize($value)
    {
        $this->setField('Size', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setWidth($value)
    {
        $this->setField('Width', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setLength($value)
    {
        $this->setField('Length', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setHeight($value)
    {
        $this->setField('Height', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setGirth($value)
    {
        $this->setField('Girth', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setOriginZip($value)
    {
        $this->setField('OriginZip', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setCommercialFlag($value)
    {
        $this->setField('CommercialFlag', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setCommercialPlusFlag($value)
    {
        $this->setField('CommercialPlusFlag', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setAcceptanceDateTime($value)
    {
        $this->setField('AcceptanceDateTime', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setDestinationPostalCode($value)
    {
        $this->setField('DestinationPostalCode', $value);

        return;
    }

    /**
     * @return array|null
     * @throws PackageException
     */
    public function toArray()
    {
        $array = $this->package;
        
        if (is_array($this->content) && count($this->content)) {
            $array['Content'] = $this->content;
        }
        
        if (is_array($this->extraServices) && count($this->extraServices)) {
            $array['ExtraServices'] = $this->extraServices;
        }
        
        if (is_array($this->gxg) && count($this->gxg)) {
            $array['GXG'] = $this->gxg;
        }

        $array = array_replace(self::FIELDS, $array);

        foreach (self::FIELDS AS $key => $value) {
            if (is_null($array[$key]) || $array[$key] === null) {
                unset($array[$key]);
            }
        }

        try {
            if (is_array($array) && count($array)) {
                Validation::validate($array, self::FIELDS);
            } else {
                return null;
            }
        } catch (ValidationException $e) {
            throw new PackageException($e->getMessage());
        }

        return $array;
    }
    
    /**
     * @param Package\Content $content
     * @return void
     */
    public function addContent(Content $content)
    {
        $this->content = $content->toArray();
    }
    
    /**
     * @param Package\ExtraServices $extraServices
     * @return void
     */
    public function addExtraServices(ExtraServices $extraServices)
    {
        $this->extraServices[] = $extraServices->toArray();
    }
    
    /**
     * @param Package\GXG $gxg
     * @return void
     */
    public function addGXG(GXG $gxg)
    {
        $this->gxg = $gxg->toArray();
    }
}
