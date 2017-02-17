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
 * NOTICE:  All information contained herein is, and remains the property of
 * Multidimension.al and its suppliers, if any.  The intellectual and
 * technical concepts contained herein are proprietary to Multidimension.al
 * and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law. Dissemination
 * of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained.
 */

namespace Multidimensional\Usps\Rate\Package;

use Multidimensional\Usps\Rate\Package;

class Content
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

    const FIELDS = [
        'ContentType' => [
            'type' => 'string',
            'pattern' => self::CONTENT_TYPE_HAZMAT . '|' . self::CONTENT_TYPE_CREMATEDREMAINS . '|' . self::CONTENT_TYPE_LIVES
        ],
        'ContentDescription' => [
            'type' => 'string',
            'required' => [
                'ContentType' => self::CONTENT_TYPE_LIVES
            ],
            'pattern' => self::CONTENT_DESCRIPTION_BEES . '|' . self::CONTENT_DESCRIPTION_DAYOLDPOULTRY . '|' . self::CONTENT_DESCRIPTION_ADULTBIRDS . '|' . self::CONTENT_DESCRIPTION_OTHER
        ]
    ];
    
    public function __construct()
    {
        
    }
    
}
