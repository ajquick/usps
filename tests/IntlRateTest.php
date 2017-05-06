<?php
/**
 *      __  ___      ____  _     ___                           _                    __
 *     /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *    / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *   / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *  /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 *  @author Multidimension.al
 *  @copyright Copyright © 2016-2017 Multidimension.al - All Rights Reserved
 *  @license Proprietary and Confidential
 *
 *  NOTICE:  All information contained herein is, and remains the property of
 *  Multidimension.al and its suppliers, if any.  The intellectual and
 *  technical concepts contained herein are proprietary to Multidimension.al
 *  and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 *  process, and are protected by trade secret or copyright law. Dissemination
 *  of this information or reproduction of this material is strictly forbidden
 *  unless prior written permission is obtained.
 */

namespace Multidimensional\USPS\Test;

use Multidimensional\USPS\IntlRate;
use PHPUnit\Framework\TestCase;

class IntlRateTest extends TestCase
{

    
    public function testRevision()
    {
        $intlRate = new IntlRate();
        $this->assertEquals($intlRate->revision, 2);
        $intlRate->setRevision(1);
        $this->assertNull($intlRate->revision);
        $intlRate->setRevision(2);
        $this->assertEquals($intlRate->revision, 2);
        $intlRate->setRevision(true);
        $this->assertNull($intlRate->revision);
        $intlRate->setRevision(false);
        $this->assertNull($intlRate->revision);
        $intlRate->setRevision(null);
        $this->assertNull($intlRate->revision);
        unset($intlRate);
        $intlRate = new IntlRate(['revision' => 1]);
        $this->assertNull($intlRate->revision);
    }
}
