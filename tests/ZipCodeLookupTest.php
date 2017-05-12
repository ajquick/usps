<?php
/**
 *     __  ___      ____  _     ___                           _                    __
 *    /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *   / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *  / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 * /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * @author Multidimension.al
 * @copyright Copyright © 2016-2017 Multidimension.al - All Rights Reserved
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

use Exception;
use Multidimensional\USPS\Address;
use Multidimensional\USPS\ZipCodeLookup;
use PHPUnit\Framework\TestCase;

class ZipCodeLookupTest extends TestCase
{
    private $address;

    public function setUp()
    {
        $defaultAddressArray = [
            '@ID' => 123,
            'FirmName' => 'The White House',
            'Address1' => '1600 Pennsylvania Ave NW',
            'City' => 'Washington',
            'State' => 'DC'
        ];
        $this->address = new Address($defaultAddressArray);
    }

    public function tearDown()
    {
        unset($this->address);
    }

    public function testConstructor()
    {
        $zipCodeLookup = new ZipCodeLookup(['Address' => $this->address]);
        $result = $zipCodeLookup->toArray();
        $expected = ['ZipCodeLookupRequest' => ['Address' => [0 => ['@ID' => 123, 'FirmName' => 'The White House', 'Address1' => null, 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC']]]];
        $this->assertEquals($expected, $result);

        $zipCodeLookup = new ZipCodeLookup(['Address' => [$this->address, $this->address]]);
        $result = $zipCodeLookup->toArray();
        $expected = ['ZipCodeLookupRequest' => ['Address' => [0 => ['@ID' => 123, 'FirmName' => 'The White House', 'Address1' => null, 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC'], 1 => ['@ID' => 123, 'FirmName' => 'The White House', 'Address1' => null, 'Address2' => '1600 Pennsylvania Ave NW', 'City' => 'Washington', 'State' => 'DC']]]];
        $this->assertEquals($expected, $result);
    }

    public function testAddAddressFailure()
    {
        $zipCodeLookup = new ZipCodeLookup();
        $zipCodeLookup->addAddress($this->address);
        $zipCodeLookup->addAddress($this->address);
        $zipCodeLookup->addAddress($this->address);
        $zipCodeLookup->addAddress($this->address);
        $zipCodeLookup->addAddress($this->address);
        try {
            $zipCodeLookup->addAddress($this->address);
        } catch (Exception $e) {
            $this->assertEquals('Address not added. You can only have a maximum of 5 addresses included in each look up request.', $e->getMessage());
        }
    }

    public function testValidate()
    {
        $zipCodeLookup = new ZipCodeLookup(['userID' => $_SERVER['USPS_USERID']]);
        $zipCodeLookup->addAddress($this->address);
        try {
            $result = $zipCodeLookup->lookup();
            $expected = [123 => ['FirmName' => 'THE WHITE HOUSE', 'Address1' => '1600 PENNSYLVANIA AVE NW', 'Address2' => null, 'City' => 'WASHINGTON', 'State' => 'DC', 'Zip5' => '20500', 'Zip4' => '0004']];
            $this->assertEquals($expected, $result);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
}
