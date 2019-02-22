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
use Multidimensional\USPS\CityStateLookup;
use Multidimensional\USPS\ZipCode;
use PHPUnit\Framework\TestCase;

class CityStateLookupTest extends TestCase
{
    private $zipCode;

    public function setUp()
    {
        $this->zipCode = new ZipCode(['ID' => 123, 'Zip5' => 20500]);
    }

    public function tearDown()
    {
        unset($this->zipCode);
    }

    public function testConstructor()
    {
        $cityStateLookup = new CityStateLookup(['ZipCode' => $this->zipCode]);
        $result = $cityStateLookup->toArray();
        $expected = ['CityStateLookupRequest' => ['ZipCode' => [0 => ['@ID' => 123, 'Zip5' => 20500]]]];
        $this->assertEquals($expected, $result);

        $cityStateLookup = new CityStateLookup(['ZipCode' => [$this->zipCode, $this->zipCode]]);
        $result = $cityStateLookup->toArray();
        $expected = ['CityStateLookupRequest' => ['ZipCode' => [0 => ['@ID' => 123, 'Zip5' => 20500], 1 => ['@ID' => 123, 'Zip5' => 20500]]]];
        $this->assertEquals($expected, $result);
    }

    public function testAddZipCodeFailure()
    {
        $cityStateLookup = new CityStateLookup();
        $cityStateLookup->addZipCode($this->zipCode);
        $cityStateLookup->addZipCode($this->zipCode);
        $cityStateLookup->addZipCode($this->zipCode);
        $cityStateLookup->addZipCode($this->zipCode);
        $cityStateLookup->addZipCode($this->zipCode);
        try {
            $cityStateLookup->addZipCode($this->zipCode);
        } catch (Exception $e) {
            $this->assertEquals('Zip code not added. You can only have a maximum of 5 zip codes included in each look up request.', $e->getMessage());
        }
    }

    public function testValidate()
    {
        $cityStateLookup = new CityStateLookup(['userID' => $_ENV['USPS_USERID']]);
        $cityStateLookup->setTestMode(true);
        $cityStateLookup->addZipCode($this->zipCode);
        try {
            $result = $cityStateLookup->lookup();
            $expected = ['123' => ['City' => 'WASHINGTON', 'State' => 'DC', 'Zip5' => '20500']];
            $this->assertEquals($expected, $result);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }

    public function testValidateMultiple()
    {
        $cityStateLookup = new CityStateLookup(['userID' => $_ENV['USPS_USERID']]);
        $cityStateLookup->setTestMode(true);
        $cityStateLookup->addZipCode($this->zipCode);
        $this->zipCode->setID(456);
        $cityStateLookup->addZipCode($this->zipCode);
        try {
            $result = $cityStateLookup->lookup();
            $expected = ['123' => ['City' => 'WASHINGTON', 'State' => 'DC', 'Zip5' => '20500'], '456' => ['City' => 'WASHINGTON', 'State' => 'DC', 'Zip5' => '20500']];
            $this->assertEquals($expected, $result);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
}
