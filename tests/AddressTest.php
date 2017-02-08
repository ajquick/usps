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

use Multidimensional\Usps\Address;
use PHPUnit_Framework_TestCase;

class AddressTest extends TestCase
{
    
	public function testEmptyAddress()
	{
		$address = new Address();
		$result = $address->toArray();
		$expected = ['@ID' => null, 'FirmName' => null, 'Address1' => null, 'Address2' => null, 'City' => null, 'State' => null, 'Urbanization' => null, 'Zip5' => null, 'Zip4' => null];
		$this->assertEqual($result, $expected, "\$canonicalize = true");
	}
	
    public function testShortAddress()
    {
        $address = new Address([
			'@ID' => 123,
			'Zip5' => 90210
		]);
		$result = $address->toArray();
		$expected = ['@ID' => 123, 'FirmName' => null, 'Address1' => null, 'Address2' => null, 'City' => null, 'State' => null, 'Urbanization' => null, 'Zip5' => 90210, 'Zip4' => null];
		$this->assertEqual($result, $expected, "\$canonicalize = true");
		$address->setField('Zip5', 90211);
		$result = $address->toArray();
		$expected = ['@ID' => 123, 'FirmName' => null, 'Address1' => null, 'Address2' => null, 'City' => null, 'State' => null, 'Urbanization' => null, 'Zip5' => 90211, 'Zip4' => null];
		$this->assertEqual($result, $expected, "\$canonicalize = true");
    }
	
	public function testFullAddress()
	{
		$address = new Address([
			'@ID' => 123,
			'FirmName' => 'XYZ Corp',
			'Address2' => '123 Fake St.',
			'City' => 'Los Angeles',
			'State' => 'NY',
			'Zip5' => 90210
		]);
		$result = $address->toArray();
		$expected = ['@ID' => 123, 'FirmName' => 'XYZ Corp', 'Address1' => null, 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Urbanization' => null, 'Zip5' => 90210, 'Zip4' => null];
		$this->assertEqual($result, $expected, "\$canonicalize = true");		
	}
	
	public function testSetFields()
	{
		$address = new Address();
		$address->setField('@ID', 123);
		$address->setField('FirmName', 'XYZ Corp');
		$address->setField('Address2', '123 Fake St.');
		$address->setField('City', 'Los Angeles');
		$address->setField('State', 'NY');
		$address->setField('Zip5', 90210);
		$result = $address->toArray();
		$expected = ['@ID' => 123, 'FirmName' => 'XYZ Corp', 'Address1' => null, 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Urbanization' => null, 'Zip5' => 90210, 'Zip4' => null];
		$this->assertEqual($result, $expected, "\$canonicalize = true");	
	}
	
	public function testManualSetFields()
	{
		$address = new Address();
		$address->setID(123);
		$address->setFirmName('XYZ Corp');
		$address->setAddress1('Apt 1.');
		$address->setAddress2('123 Fake St.');
		$address->setCity('Los Angeles');
		$address->setState('NY');
		$address->setUrbanization('ABC');
		$address->setZip5(90210);
		$address->setZip4(1234);
		$result = $address->toArray();
		$expected = ['@ID' => 123, 'FirmName' => 'XYZ Corp', 'Address1' => 'Apt 1.', 'Address2' => '123 Fake St.', 'City' => 'Los Angeles', 'State' => 'NY', 'Urbanization' => 'ABC', 'Zip5' => 90210, 'Zip4' => 1234];
		$this->assertEqual($result, $expected, "\$canonicalize = true");	
	}
    
}