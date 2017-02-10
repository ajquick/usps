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

namespace Multidimensional\Usps\Test;

use Multidimensional\Usps\Rate;
use PHPUnit_Framework_TestCase;

class RateTest extends TestCase
{
    public function testRevison()
    {
        $rate = new Rate();
        $this->assertEqual($rate->revision, 2);
        $rate->setRevision(1);
        $this->assertNull($rate->revision);
        $rate->setRevision(2);
        $this->assertEqual($rate->revision, 2);
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