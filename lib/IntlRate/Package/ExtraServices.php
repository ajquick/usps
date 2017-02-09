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

class ExtraServices extends Package
{
    
    public $fields = [
        'ExtraService' => [
            'type' => 'integer',
            'pattern' => '0|1|2|6|9'
        ]
    ];
    
    /**
     * Registered Mail 0
     * Insurance 1
     * Return Receipt 2
     * Certificate of Mailing 6
     * Electronic USPS Delivery Confirmation International 9
     */
    
}
