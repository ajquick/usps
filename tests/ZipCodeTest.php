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

namespace Multidimensional\Usps\Test;

use Multidimensional\Usps\ZipCode;
use PHPUnit\Framework\TestCase;

class ZipCodeTest extends TestCase
{
    
    public function testZipCode()
    {
        $config = ['@ID' => 0, 'Zip5' => 80110];
        $zipCode = new ZipCode($config);
        $this->assertSame($zipCode->toArray(), $config);
        $zipCode->deleteField('@ID'); 
        $zipCode->deleteField('Zip5');
        $this->assertSame($zipCode->toArray(), []);
        $zipCode->setField('@ID', 123);
        $zipCode->setField('Zip5', 90210);
        $this->assertSame($zipCode->toArray(), ['@ID' => 123, 'Zip5' => 90210]);
    }
    
}