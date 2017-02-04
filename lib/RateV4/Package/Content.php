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

namespace Multidimensional\Usps\RateV4\Package;

use Multidimensional\Usps\RateV4\Package;

class Content extends Package
{
    
    /**
     * RateV4Request / Package / Content / ContentType
     */
    const CONTENT_TYPE_HAZMAT = 'HAZMAT';
    const CONTENT_TYPE_CREMATEDREMAINS = 'CREMATEDREMAINS';
    const CONTENT_TYPE_LIVES = 'LIVES';
    
    /**
     * RateV4Request / Package / Content / ContentDescription
     */
    const CONTENT_DESCRIPTION_BEES = 'BEES';
    const CONTENT_DESCRIPTION_DAYOLDPOULTRY = 'DAYOLDPOULTRY';
    const CONTENT_DESCRIPTION_ADULTBIRDS = 'ADULTBIRDS';
    const CONTENT_DESCRIPTION_OTHER = 'OTHER';

    public $fields = [
        'ContentType' => [
            'type' => 'string',
            'pattern' => CONTENT_TYPE_HAZMAT.'|'.CONTENT_TYPE_CREMATEDREMAINS.'|'.CONTENT_TYPE_LIVES
        ],
        'ContentDescription' => [
            'type' => 'string',
            'required' => ['ContentType' => CONTENT_TYPE_LIVES],
            'pattern' => CONTENT_DESCRIPTION_BEES . '|' . CONTENT_DESCRIPTION_DAYOLDPOULTRY . '|' . CONTENT_DESCRIPTION_ADULTBIRDS . '|' . CONTENT_DESCRIPTION_OTHER
        ]
    ];
    
    public function __construct()
    {
        
    }
    
}
