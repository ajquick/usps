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

namespace Multidimensional\Usps\Test\IntlRate;

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
		$this->defaultArray = [];
	}
	
	public function tearDown()
	{
		unset($this->package);
		unset($this->defaultArray);
	}
	
	public function testAddContent()
	{
		$this->package = new Package($this->defaultArray);
		$content = new Content(['ContentType' => Content::TYPE_DOCUMENTS]);
		$this->package->addContent($content);
		$result = $this->package->toArray();
		$expected = [];
		$this->assertEquals($expected, $result);
	}
	
	public function testAddExtraServices()
	{
		$this->package = new Package($this->defaultArray);
		$extraServices = new ExtraServices([ExtraServices::REGISTERED_MAIL]);
		$this->package->addExtraServices($extraServices);
		$result = $this->package->toArray();
		$expected = [];
		$this->assertEquals($expected, $result);
	}
	
	public function testAddGXG()
	{
		$this->package = new Package($this->defaultArray);
		$gxg = new GXG(['POBoxFlag' => GXG::POBOXFLAG_YES, 'GiftFlag' => GXG::GIFTFLAG_YES]);
		$this->package->addGXG($gxg);
		$result = $this->package->toArray();
		$expected = [];
		$this->assertEquals($expected, $result);
	}
	
    public function testConstants()
    {
        $this->assertEquals('RECTANGULAR', Package::CONTAINER_RECTANGULAR);
        $this->assertEquals('NONRECTANGULAR', Package::CONTAINER_NONRECTANGULAR);
        $this->assertEquals('ALL', Package::MAIL_TYPE_ALL);
        $this->assertEquals('PACKAGE', Package::MAIL_TYPE_PACKAGE);
        $this->assertEquals('POSTCARDS', Package::MAIL_TYPE_POSTCARDS );
        $this->assertEquals('ENVELOPE', Package::MAIL_TYPE_ENVELOPE);
        $this->assertEquals('LETTER', Package::MAIL_TYPE_LETTER);
        $this->assertEquals('LARGEENVELOPE', Package::MAIL_TYPE_LARGEENVELOPE );
        $this->assertEquals('FLATRATE', Package::MAIL_TYPE_FLATRATE);
        $this->assertEquals('LARGE', Package::SIZE_LARGE);
        $this->assertEquals('REGULAR', Package::SIZE_REGULAR);    
    }   
}