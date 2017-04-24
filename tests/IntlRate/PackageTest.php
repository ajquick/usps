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

namespace Multidimensional\Usps\Test\IntlRate;

use Multidimensional\Usps\IntlRate\Exception\PackageException;
use Multidimensional\Usps\IntlRate\Package;
use Multidimensional\Usps\IntlRate\Package\Content;
use Multidimensional\Usps\IntlRate\Package\ExtraServices;
use Multidimensional\Usps\IntlRate\Package\GXG;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    public $package;
    public $defaultArray = [];
    
    public function setUp()
    {
        $this->defaultArray = ['@ID' => '123', 'Pounds' => 0.0, 'Ounces' => 16.5, 'Machinable' => true, 'MailType' => Package::MAIL_TYPE_ALL, 'ValueOfContents' => '10.0', 'Country' => 'Albania', 'Container' => Package::CONTAINER_RECTANGULAR, 'Size' => Package::SIZE_REGULAR];
    }
    
    public function tearDown()
    {
        $this->package = null;
        $this->defaultArray = [];
    }
    
    public function testDefaultArray()
    {
        $this->package = new Package($this->defaultArray);
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['GXG' => null, 'Width' => null, 'Length' => null, 'Height' => null, 'Girth' => null, 'OriginZip' => null, 'CommercialFlag' => null, 'CommercialPlusFlag' => null, 'ExtraServices' => null, 'AcceptanceDateTime' => null, 'DestinationPostalCode' => null, 'Content' => null];
        $this->assertEquals($expected, $result);
    }
    
    public function testAddContent()
    {
        $this->package = new Package($this->defaultArray);
        $content = new Content(['ContentType' => Content::TYPE_DOCUMENTS]);
        $this->package->addContent($content);
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['GXG' => null, 'Width' => null, 'Length' => null, 'Height' => null, 'Girth' => null, 'OriginZip' => null, 'CommercialFlag' => null, 'CommercialPlusFlag' => null, 'ExtraServices' => null, 'AcceptanceDateTime' => null, 'DestinationPostalCode' => null, 'Content' => ['ContentType' => Content::TYPE_DOCUMENTS, 'ContentDescription' => null]];
        $this->assertEquals($expected, $result);
    }
    
    public function testAddExtraServices()
    {
        $this->package = new Package($this->defaultArray);
        $extraServices = new ExtraServices([ExtraServices::REGISTERED_MAIL]);
        $this->package->addExtraServices($extraServices);
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['GXG' => null, 'Width' => null, 'Length' => null, 'Height' => null, 'Girth' => null, 'OriginZip' => null, 'CommercialFlag' => null, 'CommercialPlusFlag' => null, 'ExtraServices' => [['ExtraService' => ExtraServices::REGISTERED_MAIL]], 'AcceptanceDateTime' => null, 'DestinationPostalCode' => null, 'Content' => null];
        $this->assertEquals($expected, $result);
    }

    public function testMultipleExtraServices()
    {
        $this->package = new Package($this->defaultArray);
        $extraServices = new ExtraServices([ExtraServices::REGISTERED_MAIL]);
        $extraServices2 = new ExtraServices([ExtraServices::INSURANCE]);
        $this->package->addExtraServices($extraServices);
        $this->package->addExtraServices($extraServices2);
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['GXG' => null, 'Width' => null, 'Length' => null, 'Height' => null, 'Girth' => null, 'OriginZip' => null, 'CommercialFlag' => null, 'CommercialPlusFlag' => null, 'ExtraServices' => [['ExtraService' => ExtraServices::REGISTERED_MAIL],['ExtraService' => ExtraServices::INSURANCE]], 'AcceptanceDateTime' => null, 'DestinationPostalCode' => null, 'Content' => null];
        $this->assertEquals($expected, $result);
    }

    public function testAddGXG()
    {
        $this->package = new Package($this->defaultArray);
        $gxg = new GXG(['POBoxFlag' => GXG::POBOXFLAG_YES, 'GiftFlag' => GXG::GIFTFLAG_YES]);
        $this->package->addGXG($gxg);
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['GXG' => ['POBoxFlag' => GXG::POBOXFLAG_YES, 'GiftFlag' => GXG::GIFTFLAG_YES], 'Width' => null, 'Length' => null, 'Height' => null, 'Girth' => null, 'OriginZip' => null, 'CommercialFlag' => null, 'CommercialPlusFlag' => null, 'ExtraServices' => null, 'AcceptanceDateTime' => null, 'DestinationPostalCode' => null, 'Content' => null];
        $this->assertEquals($expected, $result);
    }

    public function testConstants()
    {
        $this->assertEquals('RECTANGULAR', Package::CONTAINER_RECTANGULAR);
        $this->assertEquals('NONRECTANGULAR', Package::CONTAINER_NONRECTANGULAR);
        $this->assertEquals('ALL', Package::MAIL_TYPE_ALL);
        $this->assertEquals('PACKAGE', Package::MAIL_TYPE_PACKAGE);
        $this->assertEquals('POSTCARDS', Package::MAIL_TYPE_POSTCARDS);
        $this->assertEquals('ENVELOPE', Package::MAIL_TYPE_ENVELOPE);
        $this->assertEquals('LETTER', Package::MAIL_TYPE_LETTER);
        $this->assertEquals('LARGEENVELOPE', Package::MAIL_TYPE_LARGEENVELOPE);
        $this->assertEquals('FLATRATE', Package::MAIL_TYPE_FLATRATE);
        $this->assertEquals('LARGE', Package::SIZE_LARGE);
        $this->assertEquals('REGULAR', Package::SIZE_REGULAR);
    }

    public function testNamedFunctions()
    {
        $this->package = new Package;
        $this->package->setID(123);
        $this->package->setPounds(0.0);
        $this->package->setOunces(16.5);
        $this->package->setMachinable(true);
        $this->package->setMailType('ALL');
        $this->package->setValueOfContents('10.0');
        $this->package->setCountry('Albania');
        $this->package->setContainer(Package::CONTAINER_RECTANGULAR);
        $this->package->setSize(Package::SIZE_REGULAR);
        $this->package->setWidth(12);
        $this->package->setLength(12);
        $this->package->setHeight(12);
        $this->package->setGirth(60);
        $this->package->setOriginZip(90210);
        $this->package->setCommercialFlag('Y');
        $this->package->setCommercialPlusFlag('Y');
        $this->package->setAcceptanceDateTime('2014-01-22T14:30:51-06:00');
        $this->package->setDestinationPostalCode('ABC123');
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['GXG' => null, 'Width' => 12, 'Length' => 12, 'Height' => 12, 'Girth' => 60, 'OriginZip' => 90210, 'CommercialFlag' => 'Y', 'CommercialPlusFlag' => 'Y', 'ExtraServices' => null, 'AcceptanceDateTime' => '2014-01-22T14:30:51-06:00', 'DestinationPostalCode' => 'ABC123', 'Content' => null];
        $this->assertEquals($expected, $result);
    }

    public function testFailure()
    {
        $this->package = new Package;
        try {
            $result = $this->package->toArray();
            $this->assertNull($result);
        } catch (PackageException $e) {
            $this->assertEquals('Required value not found for key: Pounds.', $e->getMessage());
        }
    }

    public function testID()
    {
        $this->defaultArray['ID'] = 123;
        unset($this->defaultArray['@ID']);
        $this->package = new Package($this->defaultArray);
        $result = $this->package->toArray();
        $this->defaultArray['@ID'] = 123;
        unset($this->defaultArray['ID']);
        $expected = $this->defaultArray + ['GXG' => null, 'Width' => null, 'Length' => null, 'Height' => null, 'Girth' => null, 'OriginZip' => null, 'CommercialFlag' => null, 'CommercialPlusFlag' => null, 'ExtraServices' => null, 'AcceptanceDateTime' => null, 'DestinationPostalCode' => null, 'Content' => null];
        $this->assertEquals($expected, $result);
    }
}
