<?php
/**
 *       __  ___      ____  _     ___                           _                    __
 *      /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *     / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *    / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *   /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 *  USPS API PHP Library
 *  Copyright (c) Multidimension.al (http://multidimension.al)
 *  Github : https://github.com/multidimension-al/usps
 *
 *  Licensed under The MIT License
 *  For full copyright and license information, please see the LICENSE file
 *  Redistributions of files must retain the above copyright notice.
 *
 *  @copyright  Copyright © 2017-2019 Multidimension.al (http://multidimension.al)
 *  @link       https://github.com/multidimension-al/usps Github
 *  @license    http://www.opensource.org/licenses/mit-license.php MIT License
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
