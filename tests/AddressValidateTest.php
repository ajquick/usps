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

use Exception;
use Multidimensional\USPS\Address;
use Multidimensional\USPS\AddressValidate;
use PHPUnit\Framework\TestCase;

class AddressValidateTest extends TestCase
{
    protected $address;

    public function setUp(): void
    {
        $defaultAddressArray = [
            'ID' => 123,
            'FirmName' => 'The White House',
            'Address1' => '1600 Pennsylvania Ave NW',
            'City' => 'Washington',
            'State' => 'DC',
            'Zip5' => '20500'
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

        $addressValidate = new AddressValidate(['IncludeOptionalElements' => true, 'ReturnCarrierRoute' => true, 'Address' => $this->address]);
        $result = $addressValidate->toArray();
        $expected = ['AddressValidateRequest' => ['IncludeOptionalElements' => true, 'ReturnCarrierRoute' => true, 'Address' => [0 => ['@ID' => 123, 'FirmName' => 'The White House', 'Address1' => null, 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC', 'Urbanization' => null, 'Zip5' => '20500', 'Zip4' => null]]]];
        $this->assertEquals($expected, $result);

        $addressValidate = new AddressValidate(['IncludeOptionalElements' => true, 'ReturnCarrierRoute' => true, 'Address' => [$this->address, $this->address]]);
        $result = $addressValidate->toArray();
        $expected = ['AddressValidateRequest' => ['IncludeOptionalElements' => true, 'ReturnCarrierRoute' => true, 'Address' => [0 => ['@ID' => 123, 'FirmName' => 'The White House', 'Address1' => null, 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC', 'Urbanization' => null, 'Zip5' => '20500', 'Zip4' => null], 1 => ['@ID' => 123, 'FirmName' => 'The White House', 'Address1' => null, 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC', 'Urbanization' => null, 'Zip5' => '20500', 'Zip4' => null]]]];
        $this->assertEquals($expected, $result);
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
        $expected = ['AddressValidateRequest' => ['Address' => [0 => ['@ID' => 123, 'FirmName' => 'The White House', 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC', 'Zip5' => '20500', 'Address1' => null, 'Urbanization' => null, 'Zip4' => null], 1 => ['@ID' => 456, 'FirmName' => 'The White House', 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC', 'Zip5' => '20500', 'Address1' => null, 'Urbanization' => null, 'Zip4' => null], 2 => ['@ID' => 789, 'FirmName' => 'The White House', 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC', 'Zip5' => '20500', 'Address1' => null, 'Urbanization' => null, 'Zip4' => null]]]];
        $this->assertEquals($expected, $result);
    }

    public function testAddAddressFailure()
    {
        $addressValidate = new AddressValidate();
        $addressValidate->addAddress($this->address);
        $addressValidate->addAddress($this->address);
        $addressValidate->addAddress($this->address);
        $addressValidate->addAddress($this->address);
        $addressValidate->addAddress($this->address);
        try {
            $addressValidate->addAddress($this->address);
        } catch (Exception $e) {
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
        $addressValidate = new AddressValidate(['userID' => $_ENV['USPS_USERID']]);
        $addressValidate->addAddress($this->address);
        try {
            $result = $addressValidate->validate();
            $expected = [123 => ['FirmName' => 'THE WHITE HOUSE', 'Address1' => '1600 PENNSYLVANIA AVE NW', 'Address2' => null, 'City' => 'WASHINGTON', 'State' => 'DC', 'Urbanization' => null, 'Zip5' => '20500', 'Zip4' => '0004', 'DeliveryPoint' => null, 'CarrierRoute' => null, 'ReturnText' => null]];
            $this->assertEquals($expected, $result);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }

    public function testValidateMultiple()
    {
        $addressValidate = new AddressValidate(['userID' => $_ENV['USPS_USERID']]);
        $addressValidate->addAddress($this->address);
        $this->address->setID(456);
        $addressValidate->addAddress($this->address);
        try {
            $result = $addressValidate->validate();
            $expected = [123 => ['FirmName' => 'THE WHITE HOUSE', 'Address1' => '1600 PENNSYLVANIA AVE NW', 'Address2' => null, 'City' => 'WASHINGTON', 'State' => 'DC', 'Urbanization' => null, 'Zip5' => '20500', 'Zip4' => '0004', 'DeliveryPoint' => null, 'CarrierRoute' => null, 'ReturnText' => null], 456 => ['FirmName' => 'THE WHITE HOUSE', 'Address1' => '1600 PENNSYLVANIA AVE NW', 'Address2' => null, 'City' => 'WASHINGTON', 'State' => 'DC', 'Urbanization' => null, 'Zip5' => '20500', 'Zip4' => '0004', 'DeliveryPoint' => null, 'CarrierRoute' => null, 'ReturnText' => null]];
            $this->assertEquals($expected, $result);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
}
