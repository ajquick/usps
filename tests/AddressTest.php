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

use Exception;
use Multidimensional\USPS\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

    public function testEmptyAddress()
    {
        $address = new Address();
        try {
            $result = $address->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Required value not found for key: @ID.', $e->getMessage());
        }
    }

    public function testShortAddress()
    {
        $address = new Address([
            '@ID' => 123,
            'Zip5' => '90210'
        ]);

        try {
            $result = $address->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Required value not found for key: Address2.', $e->getMessage());
        }

        $address->setField('Zip5', '90211');

        try {
            $result = $address->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Required value not found for key: Address2.', $e->getMessage());
        }
    }

    public function testFullAddress()
    {
        $address = new Address([
            '@ID' => 123,
            'FirmName' => 'XYZ Corp',
            'Address1' => '123 Fake St.',
            'City' => 'Los Angeles',
            'State' => 'NY',
            'Zip5' => '90210'
        ]);
        $result = $address->toArray();
        $expected = ['@ID' => 123, 'FirmName' => 'XYZ Corp', 'Address1' => null, 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Urbanization' => null, 'Zip5' => '90210', 'Zip4' => null];
        $this->assertEquals($expected, $result);
    }

    public function testSetFields()
    {
        $address = new Address();
        $address->setField('@ID', 123);
        $address->setField('FirmName', 'XYZ Corp');
        $address->setField('Address1', '123 Fake St.');
        $address->setField('City', 'Los Angeles');
        $address->setField('State', 'NY');
        $address->setField('Zip5', '90210');
        $result = $address->toArray();
        $expected = ['@ID' => 123, 'FirmName' => 'XYZ Corp', 'Address1' => null, 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Urbanization' => null, 'Zip5' => '90210', 'Zip4' => null];
        $this->assertEquals($expected, $result);
    }

    public function testManualSetFields()
    {
        $address = new Address();
        $address->setID(123);
        $address->setFirmName('XYZ Corp');
        $address->setAddress1('123 Fake St.');
        $address->setAddress2('Apt 1.');
        $address->setCity('Los Angeles');
        $address->setState('NY');
        $address->setUrbanization('ABC');
        $address->setZip5('90210');
        $address->setZip4('1234');
        $result = $address->toArray();
        $expected = ['@ID' => 123, 'FirmName' => 'XYZ Corp', 'Address1' => 'Apt 1.', 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Urbanization' => 'ABC', 'Zip5' => '90210', 'Zip4' => '1234'];
        $this->assertEquals($expected, $result);
    }

    public function testID()
    {
        $address = new Address([
            'ID' => 123,
            'FirmName' => 'XYZ Corp',
            'Address1' => '123 Fake St.',
            'City' => 'Los Angeles',
            'State' => 'NY',
            'Zip5' => '90210'
        ]);
        $result = $address->toArray();
        $expected = ['@ID' => 123, 'FirmName' => 'XYZ Corp', 'Address1' => null, 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Urbanization' => null, 'Zip5' => '90210', 'Zip4' => null];
        $this->assertEquals($expected, $result);
    }
}
