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
