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

namespace Multidimensional\Usps\Test\IntlRate\Package;

use Multidimensional\Usps\IntlRate\Package\ExtraService;
use PHPUnit\Framework\TestCase;

class ExtraServiceTest extends TestCase
{
    public $extraService;
    
    public function tearDown()
    {
        unset($this->extraService);
    }
    
    public function testNormal()
    {
        $this->extraService = new ExtraService([0]);
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 0];
        $this->assertEqual($expected, $result);
        $this->extraService->addService(1);
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 1];
        $this->assertEqual($expected, $result);
        $this->extraService->addService("0");
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 0];
        $this->assertEqual($expected, $result);
    }
    
    public function testRegisteredMail()
    {
        $this->extraService = new ExtraService([ExtraService::REGISTERED_MAIL]);
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 0];
        $this->assertEqual($expected, $result);
    }
        
    public function testInsurance()
    {
        $this->extraService = new ExtraService([ExtraService::INSURANCE]);
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 1];
        $this->assertEqual($expected, $result);
    }
    
    public function testReturnReceipt()
    {
        $this->extraService = new ExtraService([ExtraService::RETURN_RECEIPT]);
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 2];
        $this->assertEqual($expected, $result);
    }
    
    public function testCertificateOfMailing()
    {
        $this->extraService = new ExtraService([ExtraService::CERTIFICATE_OF_MAILING]);
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 6];
        $this->assertEqual($expected, $result);
    }
    
    public function testElectronicDeliveryConfirmation()
    {
        $this->extraService = new ExtraService([ExtraService::ELECTRONIC_DELIVERY_CONFIRMATION]);
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 9];
        $this->assertEqual($expected, $result);
    }
    
    public function testFailure()
    {
        $this->extraService = new ExtraService();
        $result = $this->extraService->toArray();
        $this->assertNull($result);
        $this->extraService->addService(6);
        $result = $this->extraService->toArray();
        $expected = ['ExtraService' => 6];
        $this->assertEqual($expected, $result);
        $this->extraService->addService(5);
        $result = $this->extraService->toArray();
        $this->assertNull($result);
    }
    
    public function testConstants()
    {
        $this->assertEqual(0, ExtraService::REGISTERED_MAIL);
        $this->assertEqual(1, ExtraService::INSURANCE);    
        $this->assertEqual(2, ExtraService::RETURN_RECEIPT);    
        $this->assertEqual(6, ExtraService::CERTIFICATE_OF_MAILING);    
        $this->assertEqual(9, ExtraService::ELECTRONIC_DELIVERY_CONFIRMATION);    
    }
    
}