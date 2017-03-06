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

namespace Multidimensional\Usps\Test\Rate\Package;

use Multidimensional\Usps\Rate\Package\Content;
use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    public $content;
    
    public function tearDown()
    {
        unset($this->content);    
    }
    
    public function testNormal()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
    
    public function testFailure()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
    
    public function testTypeLives()
    {
        $this->content = new Content();    
        $this->content->setContentType(Content::TYPE_LIVES);
        $this->conetnt->setContentDescription(Content::DESCRIPTION_BEES);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'LIVES', 'ContentDescription' => 'BEES'];
        $this->assertEquals($expected, $result);
    }
    
    public function testConstants()
    {
        $this->assertEquals('HAZMAT', Content::TYPE_HAZMAT);
        $this->assertEquals('CREMATEDREMAINS', Content::TYPE_CREMATEDREMAINS);
        $this->assertEquals('LIVES', Content::TYPE_LIVES);
        $this->assertEquals('BEES', Content::DESCRIPTION_BEES);
        $this->assertEquals('DAYOLDPOULTRY', Content::DESCRIPTION_DAYOLDPOULTRY);
        $this->assertEquals('ADULTBIRDS', Content::DESCRIPTION_ADULTBIRDS);
        $this->assertEquals('OTHER', Content::DESCRIPTION_OTHER);
    }    
}