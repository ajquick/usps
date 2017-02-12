<?php
/**    __  ___      ____  _     ___                           _                    __
 *    /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *   / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ / 
 *  / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /  
 * /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/   
 *                                                                                  
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

namespace Multidimensional\Usps\Rate\Package;

use Multidimensional\Usps\Rate\Package;

class SpecialServices extends Package
{
    
    public $fields = [
        'SpecialService' => [
            'type' => 'integer',
            'pattern' => '100|101|102|103|104|105|106|107|108|109|110|112|118|119|120|125|156|160|161|170|171|172|173|174|175|176|177|178|179|180'
        ]
    ];
    
    /**
     * Insurance 100
     * Insurance – Priority Mail Express 101
     * Return Receipt 102
     * Collect on Delivery 103
     * Certificate of Mailing (Form 3665) 104
     * Certified Mail 105
     * USPS Tracking 106
     * Return Receipt for Merchandise 107
     * Signature Confirmation 108
     * Registered Mail 109
     * Return Receipt Electronic 110
     * Registered mail COD collection Charge 112
     * Return Receipt – Priority Mail Express 118
     * Adult Signature Required 119
     * Adult Signature Restricted Delivery 120
     * Insurance – Priority Mail 125
     * Signature Confirmation Electronic 156
     * Certificate of Mailing (Form 3817) 160
     * Priority Mail Express 1030 AM Delivery 161
     * Certified Mail Restricted Delivery 170
     * Certified Mail Adult Signature Required 171
     * Certified Mail Adult Signature Restricted Delivery 172
     * Signature Confirm. Restrict. Delivery 173
     * Signature Confirmation Electronic Restricted Delivery 174
     * Collect on Delivery Restricted Delivery 175
     * Registered Mail Restricted Delivery 176
     * Insurance Restricted Delivery 177
     * Insurance Restrict. Delivery – Priority Mail 178
     * Insurance Restrict. Delivery – Priority Mail Express 179
     * Insurance Restrict. Delivery (Bulk Only) 180
     */
    
    public function __construct()
    {
        
    }
    
    
}
