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

namespace Multidimensional\USPS\Test\Rate\Package;

use Exception;
use Multidimensional\USPS\Rate\Package\Content;
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
        $this->content = new Content(['ContentType' => Content::TYPE_HAZMAT]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'HAZMAT', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
        $this->content->setContentType(Content::TYPE_CREMATED_REMAINS);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'CREMATEDREMAINS', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
    }

    public function testNormal()
    {
        $this->content = new Content;
        $this->content->setContentType(Content::TYPE_LIVES);
        $this->content->setContentDescription(Content::DESCRIPTION_OTHER);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'LIVES', 'ContentDescription' => 'OTHER'];
        $this->assertEquals($expected, $result);
    }

    public function testFailure()
    {
        $this->content = new Content();
        $result = $this->content->toArray();
        $expected = ['ContentType' => null, 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
        $this->content->setContentType(Content::TYPE_HAZMAT);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'HAZMAT', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
        $this->content->setContentType('Not a valid type');
        try {
            $result = $this->content->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Invalid value "Not a valid type" for key: ContentType. Did you mean "HAZMAT"?', $e->getMessage());
        }
    }

    public function testTypeHazmat()
    {
        $this->content = new Content(['ContentType' => Content::TYPE_HAZMAT]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'HAZMAT', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
    }

    public function testTypeCrematedRemains()
    {
        $this->content = new Content(['ContentType' => Content::TYPE_CREMATED_REMAINS]);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'CREMATEDREMAINS', 'ContentDescription' => null];
        $this->assertEquals($expected, $result);
    }

    public function testTypeLives()
    {
        $this->content = new Content();
        $this->content->setContentType(Content::TYPE_LIVES);
        $this->content->setContentDescription(Content::DESCRIPTION_BEES);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'LIVES', 'ContentDescription' => 'BEES'];
        $this->assertEquals($expected, $result);
        $this->content->setContentDescription(Content::DESCRIPTION_DAY_OLD_POULTRY);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'LIVES', 'ContentDescription' => 'DAYOLDPOULTRY'];
        $this->assertEquals($expected, $result);
        $this->content->setContentDescription(Content::DESCRIPTION_ADULT_BIRDS);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'LIVES', 'ContentDescription' => 'ADULTBIRDS'];
        $this->assertEquals($expected, $result);
        $this->content->setContentDescription(Content::DESCRIPTION_OTHER);
        $result = $this->content->toArray();
        $expected = ['ContentType' => 'LIVES', 'ContentDescription' => 'OTHER'];
        $this->assertEquals($expected, $result);
    }

    public function testTypeLivesFailure()
    {
        $this->content = new Content();
        $this->content->setContentType(Content::TYPE_LIVES);
        $this->content->setContentDescription(null);
        try {
            $result = $this->content->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Required value not found for key: ContentDescription.', $e->getMessage());
        }
    }

    public function testConstants()
    {
        $this->assertEquals('HAZMAT', Content::TYPE_HAZMAT);
        $this->assertEquals('CREMATEDREMAINS', Content::TYPE_CREMATED_REMAINS);
        $this->assertEquals('LIVES', Content::TYPE_LIVES);
        $this->assertEquals('BEES', Content::DESCRIPTION_BEES);
        $this->assertEquals('DAYOLDPOULTRY', Content::DESCRIPTION_DAY_OLD_POULTRY);
        $this->assertEquals('ADULTBIRDS', Content::DESCRIPTION_ADULT_BIRDS);
        $this->assertEquals('OTHER', Content::DESCRIPTION_OTHER);
    }
}
