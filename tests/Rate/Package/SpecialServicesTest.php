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

namespace Multidimensional\Usps\Test\Rate\Package;

use Multidimensional\Usps\Rate\Package\Exception\SpecialServicesException;
use Multidimensional\Usps\Rate\Package\SpecialServices;
use PHPUnit\Framework\TestCase;

class SpecialServicesTest extends TestCase
{
    
    public $specialServices;
    
    public function tearDown()
    {
        unset($this->specialServices);
    }
    
    public function testNormal()
    {
        $this->specialServices = new SpecialServices([100]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 100];
        $this->assertEquals($expected, $result);
        $this->specialServices->addService(101);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 101];
        $this->assertEquals($expected, $result);
        $this->specialServices->addService("100");
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 100];
        $this->assertEquals($expected, $result);
    }
    
    public function testFailure()
    {
        $this->specialServices = new SpecialServices();
        $result = $this->specialServices->toArray();
        $this->assertNull($result);
        $this->specialServices->addService(100);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 100];
        $this->assertEquals($expected, $result);
        $this->specialServices->addService(666);
        try {
            $result = $this->specialServices->toArray();
            $this->assertNull($result);
        } catch (SpecialServicesException $e) {
            $this->assertEquals('Invalid value "666" for key: SpecialService. Did you mean "156"?', $e->getMessage());
        }
    }
    
    public function testInsurance()
    {
        $this->specialServices = new SpecialServices([SpecialServices::INSURANCE]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 100];
        $this->assertEquals($expected, $result);
    }
    
    public function testInsurancePriorityExpress()
    {
        $this->specialServices = new SpecialServices([SpecialServices::INSURANCE_PRIORITY_EXPRESS]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 101];
        $this->assertEquals($expected, $result);
    }
    
    public function testReturnReceipt()
    {
        $this->specialServices = new SpecialServices([SpecialServices::RETURN_RECEIPT]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 102];
        $this->assertEquals($expected, $result);
    }
    
    public function testCollectOnDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::COLLECT_ON_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 103];
        $this->assertEquals($expected, $result);
    }
    
    public function testCertificateOfMailing3665()
    {
        $this->specialServices = new SpecialServices([SpecialServices::CERTIFICATE_OF_MAILING_3665]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 104];
        $this->assertEquals($expected, $result);
    }
    
    public function testCertifiedMail()
    {
        $this->specialServices = new SpecialServices([SpecialServices::CERTIFIED_MAIL]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 105];
        $this->assertEquals($expected, $result);
    }
    
    public function testUspsTracking()
    {
        $this->specialServices = new SpecialServices([SpecialServices::USPS_TRACKING]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 106];
        $this->assertEquals($expected, $result);
    }
    
    public function testReturnReceiptMerchandise()
    {
        $this->specialServices = new SpecialServices([SpecialServices::RETURN_RECEIPT_MERCHANDISE]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 107];
        $this->assertEquals($expected, $result);
    }
    
    public function testSignatureConfirmation()
    {
        $this->specialServices = new SpecialServices([SpecialServices::SIGNATURE_CONFIRMATION]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 108];
        $this->assertEquals($expected, $result);
    }
    
    public function testRegisteredMail()
    {
        $this->specialServices = new SpecialServices([SpecialServices::REGISTERED_MAIL]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 109];
        $this->assertEquals($expected, $result);
    }
    
    public function testReturnReceiptElectronic()
    {
        $this->specialServices = new SpecialServices([SpecialServices::RETURN_RECEIPT_ELECTRONIC]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 110];
        $this->assertEquals($expected, $result);
    }
    
    public function testRegisteredMailCollectOnDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::REGISTERED_MAIL_COLLECT_ON_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 112];
        $this->assertEquals($expected, $result);
    }
    
    public function testReturnReceiptPriorityExpress()
    {
        $this->specialServices = new SpecialServices([SpecialServices::RETURN_RECEIPT_PRIORITY_EXPRESS]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 118];
        $this->assertEquals($expected, $result);
    }
    
    public function testAdultSignatureRequired()
    {
        $this->specialServices = new SpecialServices([SpecialServices::ADULT_SIGNATURE_REQUIRED]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 119];
        $this->assertEquals($expected, $result);
    }
    
    public function testAdultSignatureRestrictedDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::ADULT_SIGNATURE_RESTRICTED_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 120];
        $this->assertEquals($expected, $result);
    }
    
    public function testInsurancePriority()
    {
        $this->specialServices = new SpecialServices([SpecialServices::INSURANCE_PRIORITY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 125];
        $this->assertEquals($expected, $result);
    }
    
    public function testSignatureConfirmationElectronic()
    {
        $this->specialServices = new SpecialServices([SpecialServices::SIGNATURE_CONFIRMATION_ELECTRONIC]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 156];
        $this->assertEquals($expected, $result);
    }
    
    public function testCertificateOfMailing3817()
    {
        $this->specialServices = new SpecialServices([SpecialServices::CERTIFICATE_OF_MAILING_3817]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 160];
        $this->assertEquals($expected, $result);
    }
    
    public function testPriorityExpressAMDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::PRIORITY_EXPRESS_AM_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 161];
        $this->assertEquals($expected, $result);
    }
    
    public function testCertifiedMailRestrictedDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::CERTIFIED_MAIL_RESTRICTED_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 170];
        $this->assertEquals($expected, $result);
    }
    
    public function testCertifiedMailAdultSignatureRequired()
    {
        $this->specialServices = new SpecialServices([SpecialServices::CERTIFIED_MAIL_ADULT_SIGNATURE_REQUIRED]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 171];
        $this->assertEquals($expected, $result);
    }
    
    public function testCertifiedMailAdultSignatureRestrictedDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::CERTIFIED_MAIL_ADULT_SIGNATURE_RESTRICTED_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 172];
        $this->assertEquals($expected, $result);
    }
    
    public function testSignatureConfirmationRestrictedDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::SIGNATURE_CONFIRMATION_RESTRICTED_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 173];
        $this->assertEquals($expected, $result);
    }
    
    public function testSignatureConfirmationElectronicRestrictedDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::SIGNATURE_CONFIRMATION_ELECTRONIC_RESTRICTED_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 174];
        $this->assertEquals($expected, $result);
    }
    
    public function testCollectOnDeliveryRestrictedDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::COLLECT_ON_DELIVERY_RESTRICTED_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 175];
        $this->assertEquals($expected, $result);
    }
    
    public function testRegisteredMailRestrictedDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::REGISTERED_MAIL_RESTRICTED_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 176];
        $this->assertEquals($expected, $result);
    }
    
    public function testInsuranceRestrictedDelivery()
    {
        $this->specialServices = new SpecialServices([SpecialServices::INSURANCE_RESTRICTED_DELIVERY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 177];
        $this->assertEquals($expected, $result);
    }
    
    public function testInsuranceRestrictedDeliveryPriority()
    {
        $this->specialServices = new SpecialServices([SpecialServices::INSURANCE_RESTRICTED_DELIVERY_PRIORITY]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 178];
        $this->assertEquals($expected, $result);
    }
    
    public function testInsuranceRestrictedDeliveryPriorityExpress()
    {
        $this->specialServices = new SpecialServices([SpecialServices::INSURANCE_RESTRICTED_DELIVERY_PRIORITY_EXPRESS]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 179];
        $this->assertEquals($expected, $result);
    }
    
    public function testInsuranceRestrictedDeliveryBulk()
    {
        $this->specialServices = new SpecialServices([SpecialServices::INSURANCE_RESTRICTED_DELIVERY_BULK]);
        $result = $this->specialServices->toArray();
        $expected = ['SpecialService' => 180];
        $this->assertEquals($expected, $result);
    }
    
    public function testConstants()
    {
        $this->assertEquals(100, SpecialServices::INSURANCE);
        $this->assertEquals(101, SpecialServices::INSURANCE_PRIORITY_EXPRESS);
        $this->assertEquals(102, SpecialServices::RETURN_RECEIPT);
        $this->assertEquals(103, SpecialServices::COLLECT_ON_DELIVERY);
        $this->assertEquals(104, SpecialServices::CERTIFICATE_OF_MAILING_3665);
        $this->assertEquals(105, SpecialServices::CERTIFIED_MAIL);
        $this->assertEquals(106, SpecialServices::USPS_TRACKING);
        $this->assertEquals(107, SpecialServices::RETURN_RECEIPT_MERCHANDISE);
        $this->assertEquals(108, SpecialServices::SIGNATURE_CONFIRMATION);
        $this->assertEquals(109, SpecialServices::REGISTERED_MAIL);
        $this->assertEquals(110, SpecialServices::RETURN_RECEIPT_ELECTRONIC);
        $this->assertEquals(112, SpecialServices::REGISTERED_MAIL_COLLECT_ON_DELIVERY);
        $this->assertEquals(118, SpecialServices::RETURN_RECEIPT_PRIORITY_EXPRESS);
        $this->assertEquals(119, SpecialServices::ADULT_SIGNATURE_REQUIRED);
        $this->assertEquals(120, SpecialServices::ADULT_SIGNATURE_RESTRICTED_DELIVERY);
        $this->assertEquals(125, SpecialServices::INSURANCE_PRIORITY);
        $this->assertEquals(156, SpecialServices::SIGNATURE_CONFIRMATION_ELECTRONIC);
        $this->assertEquals(160, SpecialServices::CERTIFICATE_OF_MAILING_3817);
        $this->assertEquals(161, SpecialServices::PRIORITY_EXPRESS_AM_DELIVERY);
        $this->assertEquals(170, SpecialServices::CERTIFIED_MAIL_RESTRICTED_DELIVERY);
        $this->assertEquals(171, SpecialServices::CERTIFIED_MAIL_ADULT_SIGNATURE_REQUIRED);
        $this->assertEquals(172, SpecialServices::CERTIFIED_MAIL_ADULT_SIGNATURE_RESTRICTED_DELIVERY);
        $this->assertEquals(173, SpecialServices::SIGNATURE_CONFIRMATION_RESTRICTED_DELIVERY);
        $this->assertEquals(174, SpecialServices::SIGNATURE_CONFIRMATION_ELECTRONIC_RESTRICTED_DELIVERY);
        $this->assertEquals(175, SpecialServices::COLLECT_ON_DELIVERY_RESTRICTED_DELIVERY);
        $this->assertEquals(176, SpecialServices::REGISTERED_MAIL_RESTRICTED_DELIVERY);
        $this->assertEquals(177, SpecialServices::INSURANCE_RESTRICTED_DELIVERY);
        $this->assertEquals(178, SpecialServices::INSURANCE_RESTRICTED_DELIVERY_PRIORITY);
        $this->assertEquals(179, SpecialServices::INSURANCE_RESTRICTED_DELIVERY_PRIORITY_EXPRESS);
        $this->assertEquals(180, SpecialServices::INSURANCE_RESTRICTED_DELIVERY_BULK);
    }
}
