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

namespace Multidimensional\Usps\IntlRateV2\Package;

use Multidimensional\Usps\IntlRateV2\Package;

class Content extends Package
{
    
    /**
     * IntlRateV2Request / Package / Content / ContentType
     */
    const CONTENT_TYPE_CREMATED_REMAINS = 'CrematedRemains';
    const CONTENT_TYPE_NONNEGOTIABLE_DOCUMENT = 'NonnegotiableDocument';
    const CONTENT_TYPE_PHARMACEUTICALS = 'Pharmaceuticals';
    const CONTENT_TYPE_MEDICAL_SUPPLIES = 'MedicalSupplies';
    const CONTENT_TYPE_DOCUMENTS = 'Documents';
    
    public $fields = [
        'ContentType' => [
            'type' => 'string',
            'required' => true,
            'pattern' => CONTENT_TYPE_CREMATED_REMAINS . '|' . CONTENT_TYPE_NONNEGOTIABLE_DOCUMENT . '|' .  CONTENT_TYPE_PHARMACEUTICALS . '|' . CONTENT_TYPE_MEDICAL_SUPPLIES . '|' . CONTENT_TYPE_DOCUMENTS
        ],
        'ContentDescription' => [
            'type' => 'string'
        ]
    ];
    
    
}
