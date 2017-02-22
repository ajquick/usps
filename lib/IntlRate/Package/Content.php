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

namespace Multidimensional\Usps\IntlRate\Package;

use Multidimensional\Usps\IntlRate\Package;

class Content
{

/**
 * IntlRateV2Request / Package / Content / ContentType
 */
    const CONTENT_TYPE_CREMATED_REMAINS = 'CrematedRemains';
    const CONTENT_TYPE_NONNEGOTIABLE_DOCUMENT = 'NonnegotiableDocument';
    const CONTENT_TYPE_PHARMACEUTICALS = 'Pharmaceuticals';
    const CONTENT_TYPE_MEDICAL_SUPPLIES = 'MedicalSupplies';
    const CONTENT_TYPE_DOCUMENTS = 'Documents';

    const FIELDS = [
        'ContentType' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                self::CONTENT_TYPE_CREMATED_REMAINS,
                self::CONTENT_TYPE_NONNEGOTIABLE_DOCUMENT,
                self::CONTENT_TYPE_PHARMACEUTICALS,
                self::CONTENT_TYPE_MEDICAL_SUPPLIES,
                self::CONTENT_TYPE_DOCUMENTS
            ]
        ],
        'ContentDescription' => [
            'type' => 'string'
        ]
    ];
}
