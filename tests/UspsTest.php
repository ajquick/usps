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

use Multidimensional\Usps;
use PHPUnit_Framework_TestCase;

class UspsTest extends TestCase
{
    
    public function testSetTestMode()
    {
        $this->assertTrue($this->Usps->setTestMode());
        $this->assertTrue($this->Usps->setTestMode(true));
        $this->assertFalse($this->Usps->setTestMode(false));    
    }
    
    public function testSetProductionMode()
    {
        $this->assertTrue($this->Usps->setProductionMode());
        $this->assertTrue($this->Usps->setProductionMode(true));
        $this->assertFalse($this->Usps->setProductionMode(false));            
    }
    
}