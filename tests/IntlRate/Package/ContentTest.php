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
