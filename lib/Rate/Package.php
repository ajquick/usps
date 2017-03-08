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

namespace Multidimensional\Usps\Rate;

use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;
use Multidimensional\Usps\Rate\Package\Content;
use Multidimensional\Usps\Rate\Package\SpecialServices;

class Package
{
    protected $package = [];
    protected $validation;

    const CONTAINER_VARIABLE = 'VARIABLE';
    const CONTAINER_FLAT_RATE_ENVELOPE   = 'FLAT RATE ENVELOPE';
    const CONTAINER_PADDED_FLAT_RATE_ENVELOPE = 'PADDED FLAT RATE ENVELOPE';
    const CONTAINER_LEGAL_FLAT_RATE_ENVELOPE = 'LEGAL FLAT RATE ENVELOPE';
    const CONTAINER_SM_FLAT_RATE_ENVELOPE = 'SM FLAT RATE ENVELOPE';
    const CONTAINER_WINDOW_FLAT_RATE_ENVELOPE = 'WINDOW FLAT RATE ENVELOPE';
    const CONTAINER_GIFT_CARD_FLAT_RATE_ENVELOPE = 'GIFT CARD FLAT RATE ENVELOPE';
    const CONTAINER_FLAT_RATE_BOX = 'FLAT RATE BOX';
    const CONTAINER_SM_FLAT_RATE_BOX = 'SM FLAT RATE BOX';
    const CONTAINER_MD_FLAT_RATE_BOX = 'MD FLAT RATE BOX';
    const CONTAINER_LG_FLAT_RATE_BOX = 'LG FLAT RATE BOX';
    const CONTAINER_REGIONALRATEBOXA = 'REGIONALRATEBOXA';
    const CONTAINER_REGIONALRATEBOXB = 'REGIONALRATEBOXB';
    const CONTAINER_RECTANGULAR  = 'RECTANGULAR';
    const CONTAINER_NONRECTANGULAR   = 'NONRECTANGULAR';
    const FIRST_CLASS_MAIL_TYPE_LETTER   = 'LETTER';
    const FIRST_CLASS_MAIL_TYPE_FLAT = 'FLAT';
    const FIRST_CLASS_MAIL_TYPE_PARCEL   = 'PARCEL';
    const FIRST_CLASS_MAIL_TYPE_POSTCARD = 'POSTCARD';
    const FIRST_CLASS_MAIL_TYPE_PACKAGE  = 'PACKAGE';
    const FIRST_CLASS_MAIL_TYPE_PACKAGE_SERVICE  = 'PACKAGE SERVICE';
    const SERVICE_FIRST_CLASS = 'First Class';
    const SERVICE_FIRST_CLASS_COMMERCIAL = 'First Class Commercial';
    const SERVICE_FIRST_CLASS_HFP_COMMERCIAL = 'First Class HFP Commercial';
    const SERVICE_PRIORITY   = 'Priority';
    const SERVICE_PRIORITY_COMMERCIAL = 'Priority Commercial';
    const SERVICE_PRIORITY_CPP   = 'Priority Cpp';
    const SERVICE_PRIORITY_HFP_COMMERCIAL= 'Priority HFP Commercial';
    const SERVICE_PRIORITY_HFP_CPP   = 'Priority HFP CPP';
    const SERVICE_PRIORITY_EXPRESS   = 'Priority Mail Express';
    const SERVICE_PRIORITY_EXPRESS_COMMERCIAL = 'Priority Mail Express Commercial';
    const SERVICE_PRIORITY_EXPRESS_CPP   = 'Priority Mail Express CPP';
    const SERVICE_PRIORITY_EXPRESS_SH = 'Priority Mail Express SH';
    const SERVICE_PRIORITY_EXPRESS_SH_COMMERCIAL = 'Priority Mail Express SH COMMERCIAL';
    const SERVICE_PRIORITY_EXPRESS_HFP   = 'Priority Mail Express HFP';
    const SERVICE_PRIORITY_EXPRESS_HFP_COMMERCIAL = 'Priority Mail Express HFP COMMERCIAL';
    const SERVICE_PRIORITY_EXPRESS_HFP_CPP   = 'Priority Mail Express HFP CPP';
    const SERVICE_GROUND = 'Retail Ground';
    const SERVICE_MEDIA  = 'Media';
    const SERVICE_LIBRARY = 'Library';
    const SERVICE_ALL = 'All';
    const SERVICE_ONLINE = 'Online';
    const SERVICE_PLUS   = 'Plus';
    const SIZE_LARGE = 'LARGE';
    const SIZE_REGULAR   = 'REGULAR';

    const FIELDS = [
        '@ID' => [
            'type' => 'string'
        ],
        'Service' => [
            'type' => 'string',
            'required' => true
        ],
        'FirstClassMailType' => [
            'type' => 'string',
            'required' => [
                'Service' => self::SERVICE_FIRST_CLASS,
                'Service' => self::SERVICE_FIRST_CLASS_COMMERCIAL,
                'Service' => self::SERVICE_FIRST_CLASS_HFP_COMMERCIAL
            ]
        ],
        'ZipOrigination' => [
            'type' => 'integer',
            'required' => true,
            'pattern' => '\d{5}'
        ],
        'ZipDestination' => [
            'type' => 'integer',
            'required' => true,
            'pattern' => '\d{5}'
        ],
        'Pounds' => [
            'type' => 'decimal',
            'required' => true,
            'pattern' => '\d{0,10}'
        ],
        'Ounces' => [
            'type' => 'decimal',
            'required' => true,
            'pattern' => '\d{0,10}'
        ],
        'Container' => [
            'type' => 'string',
            'required' => true,
            'default' => self::CONTAINER_VARIABLE
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
            'type' => 'decimal',
            'required' => [
                'Size' => self::SIZE_LARGE
            ],
            'pattern' => '\d{0,10}'
        ],
        'Length' => [
            'type' => 'decimal',
            'required' => [
                'Size' => self::SIZE_LARGE
            ],
            'pattern' => '\d{0,10}'
        ],
        'Height' => [
            'type' => 'decimal',
            'required' => [
                'Size' => self::SIZE_LARGE
            ],
            'pattern' => '\d{0,10}'
        ],
        'Girth' => [
            'type' => 'decimal',
            'required' => [
                [
                    'Size' => self::SIZE_LARGE,
                    'Container' => self::CONTAINER_VARIABLE
                ],
                [
                    'Size' => self::SIZE_LARGE,
                    'Container' => self::CONTAINER_NONRECTANGULAR
                ]
            ],
            'pattern' => '\d{0,10}'
        ],
        'Value' => [
            'type' => 'decimal',
            'pattern' => '\d{0,10}'
        ],
        'AmountToCollect' => [
            'type' => 'decimal',
            'pattern' => '\d{0,10}'
        ],
        'SpecialServices' => [
            'type' => 'SpecialServices',
            'fields' => SpecialServices::FIELDS
        ],
        'Content' => [
            'type' => 'Content',
            'fields' => Content::FIELDS
        ],
        'GroundOnly' => [
            'type' => 'boolean',
            'default' => false
        ],
        'SortBy' => [
            'type' => 'boolean'
        ],
        'Machinable' => [
            'type' => 'boolean',
            'required' => [
                [
                    'Service' => self::SERVICE_FIRST_CLASS,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_LETTER
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_FLAT
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_COMMERCIAL,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_LETTER
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_COMMERCIAL,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_FLAT
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_HFP_COMMERCIAL,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_LETTER
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_HFP_COMMERCIAL,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_FLAT
                ],
                ['Service' => self::SERVICE_ALL],
                ['Service' => self::SERVICE_ONLINE],
                ['Service' => self::SERVICE_GROUND]
             ]
        ],
        'ReturnLocations' => [
            'type' => 'boolean',
            'default' => true
        ],
        'ReturnServiceInfo' => [
            'type' => 'boolean'
        ],
        'DropOffTime' => [
            'type' => 'string',
            'pattern' => '\d{2}:d{2}'
        ],
        'ShipDate' => [
            'type' => 'string',
            'pattern' => '\d{4}-d{2}-d{2}'
        ]
    ];

    public function __constuct(array $config = [])
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
        
    /**
     * @param string                $key
     * @param int|bool|string|float
     * @return void
     */
    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($key, $value, self::FIELDS[$key]);
            $this->address[$key] = $value;
        }
    }
     
    /**
     * @param string $value
     * @return void
     */
    public function setService($value)
    {
        $this->setField('Service', $value);

        return;
    }
        
    /**
     * @param string $value
     * @return void
     */
    public function setFirstClassMailType($value)
    {
        $this->setField('FirstClassMailType', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setZipOrigination($value)
    {
        $this->setField('ZipOrigination', $value);

        return;
    }
        
    /**
     * @param string $value
     * @return void
     */
    public function setZipDestination($value)
    {
        $this->setField('ZipDestination', $value);

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
    public function setSize($value)
    {
        $this->setField('Size', $value);

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
    public function setValue($value)
    {
        $this->setField('Value', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setAmountToCollect($value)
    {
        $this->setField('AmountToCollect', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setGroundOnly($value)
    {
        $this->setField('GroundOnly', $value);

        return;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setSortBy($value)
    {
        $this->setField('SortBy', $value);

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
     * @return array|null
     */
    public function toArray()
    {
        if ($this->validation->validate($this->package, self::FIELDS)) {
            return $this->package;
        }
        
        return null;
    }
    
    /**
     * @param Package\Content $content
     * @return void
     */
    public function addContent(Package\Content $content)
    {
        $this->content[] = $content->toArray();
        
    }
    
    /**
     * @param Package\ExtraServices $extraServices
     * @return void
     */
    public function addExtraServices(Package\SpecialServices $specialServices)
    {
        $this->specialServices[] = $specialServices->toArray();
    }
}
