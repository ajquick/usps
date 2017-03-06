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

namespace Multidimensional\Usps\Test\IntlRate;

use Multidimensional\Usps\IntlRate\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{

    public function testConstants()
    {
        $this->assertEqual('RECTANGULAR', Package::CONTAINER_RECTANGULAR);
        $this->assertEqual('NONRECTANGULAR', Package::CONTAINER_NONRECTANGULAR);
        $this->assertEqual('ALL', Package::MAIL_TYPE_ALL);
        $this->assertEqual('PACKAGE', Package::MAIL_TYPE_PACKAGE);
        $this->assertEqual('POSTCARDS', Package::MAIL_TYPE_POSTCARDS );
        $this->assertEqual('ENVELOPE', Package::MAIL_TYPE_ENVELOPE);
        $this->assertEqual('LETTER', Package::MAIL_TYPE_LETTER);
        $this->assertEqual('LARGEENVELOPE', Package::MAIL_TYPE_LARGEENVELOPE );
        $this->assertEqual('FLATRATE', Package::MAIL_TYPE_FLATRATE);
        $this->assertEqual('LARGE', Package::SIZE_LARGE);
        $this->assertEqual('REGULAR', Package::SIZE_REGULAR);    
    }
    
}