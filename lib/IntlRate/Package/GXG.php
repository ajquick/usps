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

namespace Multidimensional\Usps\IntlRate\Package;

use Multidimensional\Usps\IntlRate\Package;

class GXG extends Package
{
    
    public $fields = [
        'POBoxFlag' => [
            'type' => 'string',
            'required' => true,
            'pattern' => 'Y|N'
        ],
        'GiftFlag' => [
            'type' => 'string',
            'required' => true,
            'pattern' => 'Y|N'
        ]
    ];
    
    public function __construct()
    {
        
    }
    
    
}
