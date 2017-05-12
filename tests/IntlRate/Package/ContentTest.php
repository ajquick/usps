<?php
/**
 *      __  ___      ____  _     ___                           _                    __
 *     /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *    / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *   / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *  /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * @author Multidimension.al
 * @copyright Copyright © 2016-2017 Multidimension.al - All Rights Reserved
 * @license Proprietary and Confidential
 *
 *  NOTICE:  All information contained herein is, and remains the property of
 *  Multidimension.al and its suppliers, if any.  The intellectual and
 *  technical concepts contained herein are proprietary to Multidimension.al
 *  and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 *  process, and are protected by trade secret or copyright law. Dissemination
 *  of this information or reproduction of this material is strictly forbidden
 *  unless prior written permission is obtained.
 */

namespace Multidimensional\USPS\Test\IntlRate\Package;

use Exception;
use Multidimensional\USPS\IntlRate\Package\Content;
use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    public $content;

    public function tearDown()
    {
        unset($this->content);
    }

    public function testInitialize()
    {
        $this->content = new Content(['ContentType' => Content::TYPE_DOCUMENTS]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => Content::TYPE_DOCUMENTS, 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
    }

    public function testNormal()
    {
        $this->content = new Content;
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
        try {
            $result = $this->content->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Required value not found for key: ContentType.', $e->getMessage());
        }
        $this->content->setContentType(Content::TYPE_DOCUMENTS);
        $result = $this->content->toArray();
        $expected = ['ContentType' => Content::TYPE_DOCUMENTS, 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
        $this->content->setContentType('Not a valid type');
        try {
            $result = $this->content->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Invalid value "Not a valid type" for key: ContentType. Did you mean "MedicalSupplies"?', $e->getMessage());
        }
    }

    public function testCrematedRemains()
    {
        $this->content = new Content(['ContentType' => Content::TYPE_CREMATED_REMAINS]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'CrematedRemains', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
    }

    public function testNonnegotiableDocument()
    {
        $this->content = new Content(['ContentType' => Content::TYPE_NONNEGOTIABLE_DOCUMENT]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'NonnegotiableDocument', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
    }

    public function testPharmaceuticals()
    {
        $this->content = new Content(['ContentType' => Content::TYPE_PHARMACEUTICALS]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'Pharmaceuticals', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
    }

    public function testMedicalSupplies()
    {
        $this->content = new Content(['ContentType' => Content::TYPE_MEDICAL_SUPPLIES]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'MedicalSupplies', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
    }

    public function testDocuments()
    {
        $this->content = new Content(['ContentType' => Content::TYPE_DOCUMENTS]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'Documents', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
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
