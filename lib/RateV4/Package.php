<?php
/**
 * CONFIDENTIAL
 *
 * © 2017 Multidimension.al - All Rights Reserved
 * 
 * NOTICE:  All information contained herein is, and remains
 * the property of Multidimension.al and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to Multidimension.al and its suppliers
 * and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained.
 */

namespace Multidimensional\Usps\RateV4;

class Package extends RateV4
{
    /**
     * @var array
     */
    protected $package = [];
    
    /**
     * RateV4Request / Package / Container
     */
    const CONTAINER_VARIABLE                         = 'VARIABLE';
    const CONTAINER_FLAT_RATE_ENVELOPE               = 'FLAT RATE ENVELOPE';
    const CONTAINER_PADDED_FLAT_RATE_ENVELOPE        = 'PADDED FLAT RATE ENVELOPE';
    const CONTAINER_LEGAL_FLAT_RATE_ENVELOPE         = 'LEGAL FLAT RATE ENVELOPE';
    const CONTAINER_SM_FLAT_RATE_ENVELOPE            = 'SM FLAT RATE ENVELOPE';
    const CONTAINER_WINDOW_FLAT_RATE_ENVELOPE        = 'WINDOW FLAT RATE ENVELOPE';
    const CONTAINER_GIFT_CARD_FLAT_RATE_ENVELOPE     = 'GIFT CARD FLAT RATE ENVELOPE';
    const CONTAINER_FLAT_RATE_BOX                    = 'FLAT RATE BOX';
    const CONTAINER_SM_FLAT_RATE_BOX                 = 'SM FLAT RATE BOX';
    const CONTAINER_MD_FLAT_RATE_BOX                 = 'MD FLAT RATE BOX';
    const CONTAINER_LG_FLAT_RATE_BOX                 = 'LG FLAT RATE BOX';
    const CONTAINER_REGIONALRATEBOXA                 = 'REGIONALRATEBOXA';
    const CONTAINER_REGIONALRATEBOXB                 = 'REGIONALRATEBOXB';
    const CONTAINER_RECTANGULAR                      = 'RECTANGULAR';
    const CONTAINER_NONRECTANGULAR                   = 'NONRECTANGULAR';
    
    /**
     * RateV4Request / Package / FirstClassMailType
     */
    const FIRST_CLASS_MAIL_TYPE_LETTER               = 'LETTER';
    const FIRST_CLASS_MAIL_TYPE_FLAT                 = 'FLAT';
    const FIRST_CLASS_MAIL_TYPE_PARCEL               = 'PARCEL';
    const FIRST_CLASS_MAIL_TYPE_POSTCARD             = 'POSTCARD';
    const FIRST_CLASS_MAIL_TYPE_PACKAGE              = 'PACKAGE';
    const FIRST_CLASS_MAIL_TYPE_PACKAGE_SERVICE      = 'PACKAGE SERVICE';

    /**
     * RateV4Request / Package / Service
     */     
    const SERVICE_FIRST_CLASS                        = 'First Class';
    const SERVICE_FIRST_CLASS_COMMERCIAL             = 'First Class Commercial';
    const SERVICE_FIRST_CLASS_HFP_COMMERCIAL         = 'First Class HFP Commercial';
    const SERVICE_PRIORITY                           = 'Priority';
    const SERVICE_PRIORITY_COMMERCIAL                = 'Priority Commercial';
    const SERVICE_PRIORITY_CPP                       = 'Priority Cpp';
    const SERVICE_PRIORITY_HFP_COMMERCIAL            = 'Priority HFP Commercial';
    const SERVICE_PRIORITY_HFP_CPP                   = 'Priority HFP CPP';
    const SERVICE_PRIORITY_EXPRESS                   = 'Priority Mail Express';
    const SERVICE_PRIORITY_EXPRESS_COMMERCIAL        = 'Priority Mail Express Commercial';
    const SERVICE_PRIORITY_EXPRESS_CPP               = 'Priority Mail Express CPP';
    const SERVICE_PRIORITY_EXPRESS_SH                = 'Priority Mail Express SH';
    const SERVICE_PRIORITY_EXPRESS_SH_COMMERCIAL     = 'Priority Mail Express SH COMMERCIAL';
    const SERVICE_PRIORITY_EXPRESS_HFP               = 'Priority Mail Express HFP';
    const SERVICE_PRIORITY_EXPRESS_HFP_COMMERCIAL    = 'Priority Mail Express HFP COMMERCIAL';
    const SERVICE_PRIORITY_EXPRESS_HFP_CPP           = 'Priority Mail Express HFP CPP';
    const SERVICE_GROUND                             = 'Retail Ground';
    const SERVICE_MEDIA                              = 'Media';
    const SERVICE_LIBRARY                            = 'Library';
    const SERVICE_ALL                                = 'All';
    const SERVICE_ONLINE                             = 'Online';
    const SERVICE_PLUS                               = 'Plus';
    
    /**
     * RateV4Request / Package / Size
     */
    const SIZE_LARGE                                 = 'LARGE';
    const SIZE_REGULAR                               = 'REGULAR';
    
    /**
     * @var array $fields
     */
    public $fields = [
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
                'Service' => SERVICE_FIRST_CLASS,
                'Service' => SERVICE_FIRST_CLASS_COMMERCIAL,
                'Service' => SERVICE_FIRST_CLASS_HFP_COMMERCIAL
            ]
        ],
        'ZipOrigination' => [
            'type' => 'integer',
            'required' => true,
            'pattern' => 'd{5}'
        ],
        'ZipDestination' => [
            'type' => 'integer',
            'required' => true,
            'pattern' => 'd{5}'
        ],
        'Pounds' => [
            'type' => 'decimal',
            'required' => true,
            'pattern' => 'd{0,10}'
        ],
        'Ounces' => [
            'type' => 'decimal',
            'required' => true,
            'pattern' => 'd{0,10}'
        ],
        'Container' => [
            'type' => 'string',
            'required' => true,
            'default' => 'VARIABLE'
        ],
        'Size' => [
            'type' => 'string',
            'required' => true,
            'pattern' => 'REGULAR|LARGE'
        ],
        'Width' => [
            'type' => 'decimal',
            'required' => [
                'Size' => SIZE_LARGE
            ],
            'pattern' => 'd{0,10}'
        ],
        'Length' => [
            'type' => 'decimal',
            'required' => [
                'Size' => SIZE_LARGE
            ],
            'pattern' => 'd{0,10}'
        ],
        'Height' => [
            'type' => 'decimal',
            'required' => [
                'Size' => SIZE_LARGE
            ],
            'pattern' => 'd{0,10}'],
        'Girth' => [
            'type' => 'decimal',
            'required' => [
                [
                    'Size' => SIZE_LARGE,
                    'Container' => CONTAINER_VARIABLE
                ],
                [
                    'Size' => SIZE_LARGE,
                    'Container' => CONTAINER_NONRECTANGULAR
                ]
            ],
            'pattern' => 'd{0,10}'
        ],
        'Value' => [
            'type' => 'decimal',
            'pattern' => 'd{0,10}'
        ],
        'AmountToCollect' => [
            'type' => 'decimal',
            'pattern' => 'd{0,10}'
        ],
        'SpecialServices' => [
            'type' => 'SpecialServices'
        ],
        'Content' => [
            'type' => 'Content'
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
                    [
                        'Service' => SERVICE_FIRST_CLASS,
                        'FirstClassMailType' => FIRST_CLASS_MAIL_TYPE_LETTER
                    ],
                ],
                [
                    [
                        'Service' => SERVICE_FIRST_CLASS,
                        'FirstClassMailType' => FIRST_CLASS_MAIL_TYPE_FLAT
                    ]
                ],
                [
                    [
                        'Service' => SERVICE_FIRST_CLASS_COMMERCIAL,
                        'FirstClassMailType' => FIRST_CLASS_MAIL_TYPE_LETTER
                    ]
                ],
                [
                    [
                        'Service' => SERVICE_FIRST_CLASS_COMMERCIAL,
                        'FirstClassMailType' => FIRST_CLASS_MAIL_TYPE_FLAT
                    ]
                ],
                [
                    [
                        'Service' => SERVICE_FIRST_CLASS_HFP_COMMERCIAL,
                        'FirstClassMailType' => FIRST_CLASS_MAIL_TYPE_LETTER
                    ]
                ],
                [
                    [
                        'Service' => SERVICE_FIRST_CLASS_HFP_COMMERCIAL,
                        'FirstClassMailType' => FIRST_CLASS_MAIL_TYPE_FLAT
                    ]
                ],
                ['Service' => SERVICE_ALL],
                ['Service' => SERVICE_ONLINE],
                ['Service' => SERVICE_GROUND]
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
            'pattern' => 'd{2}:d{2}'
        ],
        'ShipDate' => [
            'type' => 'string',
            'pattern' => 'd{4}-d{2}-d{2}'
        ]
    ];

    public function __constuct(array $config = []) 
    {
                            
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->package;
    }

}