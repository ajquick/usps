<?php
/**
 *     __  ___      ____  _     ___                           _                    __
 *    /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *   / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *  / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 * /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * @author Multidimension.al
 * @copyright Copyright © 2016-2018 Multidimension.al - All Rights Reserved
 * @license Proprietary and Confidential
 *
 * NOTICE:  All information contained herein is, and remains the property of
 * Multidimension.al and its suppliers, if any.  The intellectual and
 * technical concepts contained herein are proprietary to Multidimension.al
 * and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law. Dissemination
 * of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained.
 */

namespace Multidimensional\USPS\Test;

use Multidimensional\USPS\USPS;
use PHPUnit\Framework\TestCase;

class USPSTest extends TestCase
{
    public $usps;

    public function setUp()
    {
        $this->usps = new USPS();
    }

    public function tearDown()
    {
        unset($this->usps);
    }

    public function testSetTestMode()
    {
        $this->assertFalse($this->usps->testMode);
        $this->usps->setTestMode(true);
        $this->assertTrue($this->usps->testMode);
        $this->usps->setProductionMode();
        $this->assertFalse($this->usps->testMode);
        $this->usps->setTestMode();
        $this->assertTrue($this->usps->testMode);
        $this->usps->setTestMode(false);
        $this->assertFalse($this->usps->testMode);
    }

    public function testSetSecureMode()
    {
        $this->assertFalse($this->usps->secureMode);
        $this->usps->setSecureMode(true);
        $this->assertTrue($this->usps->secureMode);
        $this->usps->setSecureMode(false);
        $this->assertFalse($this->usps->secureMode);
    }

    public function testSetCredentials()
    {
        unset($this->usps);
        $this->usps = new USPS(['userID' => 'USERID123', 'password' => '123']);
        $this->usps->setCredentials('USERID456', '456');
        $this->usps->setUserID('USERID789');
        $this->usps->setPassword('789');
        $this->assertTrue(true);
    }
}
