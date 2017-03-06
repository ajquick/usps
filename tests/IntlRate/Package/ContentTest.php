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

namespace Multidimensional\Usps\Test\IntlRate\Package;

use Multidimensional\Usps\IntlRate\Package\Content;
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
        $this->content = new Content();
        $this->content->setContentType(Content::TYPE_DOCUMENTS);
        $result = $this->content->toArray();
        $expected = ['ContentType' => Content::TYPE_DOCUMENTS, 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
        $this->content->setContentDescription('This is something.');
        $result = $this->content->toArray();
        $expected = ['ContentType' => Content::TYPE_DOCUMENTS, 'ContentDescription' => 'This is something.'];
        $this->assertEquals($expected, $result);
    }
    
    public function testFailure()
    {
        $this->content = new Content();
        $result = $this->content->toArray();
        $expected = ['ContentType' => null, 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
        $this->content->setContentType(Content::TYPE_DOCUMENTS);
        $result = $this->content->toArray();
        $expected = ['ContentType' => Content::TYPE_DOCUMENTS, 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
        $this->content->setContentType('Not a valid type');
        $result = $this->content->toArray();
        $this->assertNull($result);            
    }
    
    public function testConstants()
    {
        $this->assertEquals('CrematedRemains', Content::TYPE_CREMATED_REMAINS);
        $this->assertEquals('NonnegotiableDocument', Content::TYPE_NONNEGOTIABLE_DOCUMENT);
        $this->assertEquals('Pharmaceuticals', Content::TYPE_PHARMACEUTICALS);
        $this->assertEquals('MedicalSupplies', Content::TYPE_MEDICAL_SUPPLIES);
        $this->assertEquals('Documents', Content::TYPE_DOCUMENTS);    
    } 
}