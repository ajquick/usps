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

namespace Multidimensional\USPS\Test\IntlRate\Package;

use Exception;
use Multidimensional\USPS\IntlRate\Package\ExtraServices;
use PHPUnit\Framework\TestCase;

class ExtraServicesTest extends TestCase
{
    protected $extraServices;

    public function tearDown()
    {
        unset($this->extraServices);
    }

    public function testNormal()
    {
        $this->extraServices = new ExtraServices([0]);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 0];
        $this->assertEquals($expected, $result);
        $this->extraServices->addService(1);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 1];
        $this->assertEquals($expected, $result);
        $this->extraServices->addService("0");
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 0];
        $this->assertEquals($expected, $result);
    }

    public function testRegisteredMail()
    {
        $this->extraServices = new ExtraServices([ExtraServices::REGISTERED_MAIL]);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 0];
        $this->assertEquals($expected, $result);
    }

    public function testInsurance()
    {
        $this->extraServices = new ExtraServices([ExtraServices::INSURANCE]);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 1];
        $this->assertEquals($expected, $result);
    }

    public function testReturnReceipt()
    {
        $this->extraServices = new ExtraServices([ExtraServices::RETURN_RECEIPT]);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 2];
        $this->assertEquals($expected, $result);
    }

    public function testCertificateOfMailing()
    {
        $this->extraServices = new ExtraServices([ExtraServices::CERTIFICATE_OF_MAILING]);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 6];
        $this->assertEquals($expected, $result);
    }

    public function testElectronicDeliveryConfirmation()
    {
        $this->extraServices = new ExtraServices([ExtraServices::ELECTRONIC_DELIVERY_CONFIRMATION]);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 9];
        $this->assertEquals($expected, $result);
    }

    public function testFailure()
    {
        $this->extraServices = new ExtraServices();
        try {
            $result = $this->extraServices->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Invalid value "5" for key: ExtraService. Did you mean "0"?', $e->getMessage());
        }
        $this->extraServices->addService(6);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 6];
        $this->assertEquals($expected, $result);
        $this->extraServices->addService(5);
        try {
            $result = $this->extraServices->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Invalid value "5" for key: ExtraService. Did you mean "0"?', $e->getMessage());
        }
    }

    public function testOtherInputMethod()
    {
        $this->extraServices = new ExtraServices(['ExtraService' => ExtraServices::INSURANCE]);
        $result = $this->extraServices->toArray();
        $expected = ['ExtraService' => 1];
        $this->assertEquals($expected, $result);
    }

    public function testConstants()
    {
        $this->assertEquals(0, ExtraServices::REGISTERED_MAIL);
        $this->assertEquals(1, ExtraServices::INSURANCE);
        $this->assertEquals(2, ExtraServices::RETURN_RECEIPT);
        $this->assertEquals(6, ExtraServices::CERTIFICATE_OF_MAILING);
        $this->assertEquals(9, ExtraServices::ELECTRONIC_DELIVERY_CONFIRMATION);
    }
}
