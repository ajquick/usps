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

namespace Multidimensional\Usps\IntlRate;

use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class Package
{

/**
 * IntlRate / Request / Package / Container
 */
    const CONTAINER_RECTANGULAR = 'RECTANGULAR';
    const CONTAINER_NONRECTANGULAR  = 'NONRECTANGULAR';

/**
 * IntlRate / Request / Package / MailType
 */
    const MAIL_TYPE_ALL = 'ALL';
    const MAIL_TYPE_PACKAGE = 'PACKAGE';
    const MAIL_TYPE_POSTCARDS   = 'POSTCARDS';
    const MAIL_TYPE_ENVELOPE = 'ENVELOPE';
    const MAIL_TYPE_LETTER  = 'LETTER';
    const MAIL_TYPE_LARGEENVELOPE   = 'LARGEENVELOPE';
    const MAIL_TYPE_FLATRATE = 'FLATRATE';

/**
 * IntlRate / Request / Package / Size
 */
    const SIZE_LARGE = 'LARGE';
    const SIZE_REGULAR  = 'REGULAR';

    const FIELDS = [
        '@ID' => [
            'type' => 'string'
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
        'Machinable' => [
            'type' => 'boolean',
            'default' => true
        ],
        'MailType' => [
            'type' => 'string',
            'required' => true
        ],
        'GXG' => [
            'type' => 'GXG'
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
            'required' => true
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
            'type' => 'ExtraServices',
            'fields' => ExtraServices::fields
        ],
        'AcceptanceDataTime' => [
            'type' => 'DateTime',
            'pattern' => 'ISO 8601'
        ],
        'DestinationPostalCode' => [
            'type' => 'string'
        ],
        'Content' => [
            'type' => 'Content',
            'fields' => Content::fields
        ]
    ];

    public function __constuct(array $config = [])
    {

        //Required
        //ID
        //Pounds
        //Ounces
        //MailType
        //ValueOfContents
        //Country
        //Container
        //Size
        //Width
        //Length
        //Height
        //Girth
    }
	
	
    /**
     * @param string $value
     * @return void
     */
    public function setPounds($value)
    {
        $this->setField('Pounds', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setOunces($value)
    {
        $this->setField('Ounces', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setMachinable($value)
    {
        $this->setField('Machinable', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setMailType($value)
    {
        $this->setField('MailType', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setValueOfContents($value)
    {
        $this->setField('ValueOfContents', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setCountry($value)
    {
        $this->setField('Country', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setContainer($value)
    {
        $this->setField('Container', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setSize($value)
    {
        $this->setField('Size', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setWidth($value)
    {
        $this->setField('Width', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setLength($value)
    {
        $this->setField('Length', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setHeight($value)
    {
        $this->setField('Height', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setGirth($value)
    {
        $this->setField('Girth', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setOriginZip($value)
    {
        $this->setField('OriginZip', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setCommercialFlag($value)
    {
        $this->setField('CommercialFlag', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setCommercialPlusFlag($value)
    {
        $this->setField('CommercialPlusFlag', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setExtraServices($value)
    {
        $this->setField('ExtraServices', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setAcceptanceDataTime($value)
    {
        $this->setField('AcceptanceDataTime', $value);
    }
	
    /**
     * @param string $value
     * @return void
     */
    public function setDestinationPostalCode($value)
    {
        $this->setField('DestinationPostalCode', $value);
    }
	
	public function toArray()
	{
			
	}
	
	public function addContent($array) 
	{
			
	}
	
	public function addExtraService($array)
	{
		
	}
	
	public function addGXG($array)
	{
		
	}
}
