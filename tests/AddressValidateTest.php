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

use Multidimensional\Usps\Address;
use Multidimensional\Usps\AddressValidate;
use Multidimensional\Usps\Exception\AddressException;
use Multidimensional\Usps\Exception\AddressValidateException;
use PHPUnit\Framework\TestCase;

class AddressValidateTest extends TestCase
{
    protected $address;

    public function setUp()
    {
        $defaultAddressArray = [
            '@ID' => 123,
            'FirmName' => 'XYZ Corp',
            'Address2' => '123 Fake St.',
            'City' => 'Los Angeles',
            'State' => 'NY',
            'Zip5' => '90210'
        ];
        $this->address = new Address($defaultAddressArray);
    }

    public function tearDown()
    {
        unset($this->address);
    }

    public function testConstructor()
    {
        $addressValidate = new AddressValidate(['IncludeOptionalElements' => true, 'ReturnCarrierRoute' => true]);
        $result = $addressValidate->toArray();
        $this->assertArrayHasKey('IncludeOptionalElements', $result['AddressValidateRequest']);
        $this->assertArrayHasKey('ReturnCarrierRoute', $result['AddressValidateRequest']);
    }

    public function testAddAddress()
    {
        $addressValidate = new AddressValidate();
        $this->assertTrue($addressValidate->addAddress($this->address));
    }

    public function testAddMultipleAddresses()
    {
        $addressValidate = new AddressValidate();
        $addressValidate->addAddress($this->address);
        $this->address->setID('456');
        $addressValidate->addAddress($this->address);
        $this->address->setID('789');
        $addressValidate->addAddress($this->address);
        $result = $addressValidate->toArray();
        $expected = ['AddressValidateRequest' => ['Address' => [0 => ['@ID' => 123, 'FirmName' => 'XYZ Corp', 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Zip5' => '90210', 'Address1' => null, 'Urbanization' => null, 'Zip4' => null], 1 => ['@ID' => 456, 'FirmName' => 'XYZ Corp', 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Zip5' => '90210', 'Address1' => null, 'Urbanization' => null, 'Zip4' => null], 2 => ['@ID' => 789, 'FirmName' => 'XYZ Corp', 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Zip5' => '90210', 'Address1' => null, 'Urbanization' => null, 'Zip4' => null]]]];
        $this->assertEquals($expected, $result);
    }

    public function testAddAddressFailure()
    {
        $addressValidate = new AddressValidate();
        $this->assertTrue($addressValidate->addAddress($this->address));
        $this->assertTrue($addressValidate->addAddress($this->address));
        $this->assertTrue($addressValidate->addAddress($this->address));
        $this->assertTrue($addressValidate->addAddress($this->address));
        $this->assertTrue($addressValidate->addAddress($this->address));
        try {
            $addressValidate->addAddress($this->address);
        } catch (AddressValidateException $e) {
            $this->assertEquals('Address not added. You can only have a maximum of 5 addresses included in each look up request.', $e->getMessage());
        }
    }

    public function testIncludeOptionalElements()
    {
        $addressValidate = new AddressValidate();
        $addressValidate->setIncludeOptionalElements(true);
        $result = $addressValidate->toArray();
        $this->assertArrayHasKey('IncludeOptionalElements', $result['AddressValidateRequest']);
        $addressValidate->setIncludeOptionalElements(false);
        $result = $addressValidate->toArray();
        $this->assertArrayNotHasKey('IncludeOptionalElements', $result['AddressValidateRequest']);
    }

    public function testReturnCarrierRoute()
    {
        $addressValidate = new AddressValidate();
        $addressValidate->setReturnCarrierRoute(true);
        $result = $addressValidate->toArray();
        $this->assertArrayHasKey('ReturnCarrierRoute', $result['AddressValidateRequest']);
        $addressValidate->setReturnCarrierRoute(false);
        $result = $addressValidate->toArray();
        $this->assertArrayNotHasKey('ReturnCarrierRoute', $result['AddressValidateRequest']);
    }

    public function testValidate()
    {
        $addressValidate = new AddressValidate();
        $addressValidate->addAddress($this->address);
        $addressValidate->validate();
    }
}
