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

namespace Multidimensional\Usps\Test;

use Multidimensional\Usps\Rate;
use PHPUnit\Framework\TestCase;

class RateTest extends TestCase
{
    public function testRevision()
    {
        $rate = new Rate();
        $this->assertEquals($rate->revision, 2);
        $rate->setRevision(1);
        $this->assertNull($rate->revision);
        $rate->setRevision(2);
        $this->assertEquals($rate->revision, 2);
        $rate->setRevision(true);
        $this->assertNull($rate->revision);
        $rate->setRevision(false);
        $this->assertNull($rate->revision);
        $rate->setRevision(null);
        $this->assertNull($rate->revision);
        unset($rate);
        $rate = new Rate(['revision' => 1]);
        $this->assertNull($rate->revision);
    }
}
