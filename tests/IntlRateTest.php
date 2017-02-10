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

use Multidimensional\Usps\IntlRate;
use PHPUnit_Framework_TestCase;

class IntlRateTest extends TestCase
{    
    public function testRevison()
    {
        $intlRate = new IntlRate();
        $this->assertEqual($intlRate->revision, 2);
        $intlRate->setRevision(1);
        $this->assertNull($intlRate->revision);
        $intlRate->setRevision(2);
        $this->assertEqual($intlRate->revision, 2);
        $intlRate->setRevision(true);
        $this->assertNull($intlRate->revision);
        $intlRate->setRevision(false);
        $this->assertNull($intlRate->revision);
        $intlRrate->setRevision(null);
        $this->assertNull($intlRate->revision);
        unset($intlRate);        
        $intlRate = new IntlRate(['revision' => 1]);
        $this->assertNull($intlRate->revision);
        
    }    
    }
    
}