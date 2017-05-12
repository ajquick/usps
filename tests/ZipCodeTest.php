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

namespace Multidimensional\USPS\Test;

use \Exception;
use Multidimensional\USPS\ZipCode;
use PHPUnit\Framework\TestCase;

class ZipCodeTest extends TestCase
{
    
    public function testZipCode()
    {
        $config = ['@ID' => 0, 'Zip5' => '90210'];
        $zipCode = new ZipCode($config);
        $result = $zipCode->toArray();
        $expected = $config;
        $this->assertEquals($expected, $result);
        $zipCode->setField('@ID', 123);
        $zipCode->setField('Zip5', '90210');
        $result = $zipCode->toArray();
        $expected = ['@ID' => 123, 'Zip5' => '90210'];
        $this->assertEquals($expected, $result);
    }
    
    public function testFailure()
    {
        $zipCode = new ZipCode();
        try {
            $zipCode->toArray();
        } catch (Exception $e) {
            $this->assertEquals('Required value not found for key: @ID.', $e->getMessage());
        }
    }

    public function testSetFields()
    {
        $zipCode = new ZipCode();
        $zipCode->setID(123);
        $zipCode->setZip5('90210');
        $result = $zipCode->toArray();
        $expected = ['@ID' => 123, 'Zip5' => '90210'];
        $this->assertEquals($expected, $result);
    }

    public function testID()
    {
        $config = ['ID' => 123, 'Zip5' => '90210'];
        $zipCode = new ZipCode($config);
        $result = $zipCode->toArray();
        $expected = ['@ID' => 123, 'Zip5' => '90210'];
        $this->assertEquals($expected, $result);
    }
}
