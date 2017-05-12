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
use Multidimensional\USPS\Rate;
use Multidimensional\USPS\Rate\Package;
use PHPUnit\Framework\TestCase;

class RateTest extends TestCase
{
    private $package;

    public function setUp()
    {
        $defaultArray = ['@ID' => '123', 'Service' => 'All', 'FirstClassMailType' => 'PARCEL', 'ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0, 'Ounces' => 32, 'Container' => 'VARIABLE', 'Size' => 'REGULAR', 'Machinable' => true];
        $this->package = new Package($defaultArray);
    }

    public function tearDown()
    {
        unset($this->package);
    }

    public function testConstructor()
    {
        $rate = new Rate(['Revision' => 2, 'Package' => $this->package]);
        $result = $rate->toArray();
        $expected = ['RateV4Request' => ['Revision' => 2, 'Package' => [0 => ['@ID' => '123', 'Service' => 'All', 'FirstClassMailType' => 'PARCEL', 'ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0.0, 'Ounces' => 32.0, 'Container' => 'VARIABLE', 'Size' => 'REGULAR', 'Machinable' => true]]]];
        $this->assertEquals($expected, $result);
        unset($rate);
        $rate = new Rate(['Revision' => 2, 'Package' => [$this->package, $this->package]]);
        $result = $rate->toArray();
        $expected = ['RateV4Request' => ['Revision' => 2, 'Package' => [0 => ['@ID' => '123', 'Service' => 'All', 'FirstClassMailType' => 'PARCEL', 'ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0.0, 'Ounces' => 32.0, 'Container' => 'VARIABLE', 'Size' => 'REGULAR', 'Machinable' => true], 1 => ['@ID' => '123', 'Service' => 'All', 'FirstClassMailType' => 'PARCEL', 'ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0.0, 'Ounces' => 32.0, 'Container' => 'VARIABLE', 'Size' => 'REGULAR', 'Machinable' => true]]]];
        $this->assertEquals($expected, $result);
    }

    public function testRevision()
    {
        $rate = new Rate();
        $result = $rate->toArray();
        $this->assertArrayHasKey('Revision', $result['RateV4Request']);
        $this->assertEquals(2, $result['RateV4Request']['Revision']);
        $rate->setRevision(1);
        $result = $rate->toArray();
        $this->assertNull($result);
        $rate->setRevision(2);
        $result = $rate->toArray();
        $this->assertArrayHasKey('Revision', $result['RateV4Request']);
        $this->assertEquals(2, $result['RateV4Request']['Revision']);
        $rate->setRevision(true);
        $result = $rate->toArray();
        $this->assertNull($result);
        $rate->setRevision(false);
        $result = $rate->toArray();
        $this->assertNull($result);
        $rate->setRevision(null);
        $result = $rate->toArray();
        $this->assertNull($result);
        unset($rate);
        $rate = new Rate(['revision' => 1]);
        $result = $rate->toArray();
        $this->assertNull($result);
    }

    public function testAddPackage()
    {
        $rate = new Rate(['Package' => $this->package]);
        $result = $rate->toArray();
        $expected = ['RateV4Request' => ['Revision' => 2, 'Package' => [0 => ['@ID' => '123', 'Service' => 'All', 'FirstClassMailType' => 'PARCEL', 'ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0.0, 'Ounces' => 32.0, 'Container' => 'VARIABLE', 'Size' => 'REGULAR', 'Machinable' => true]]]];
        $this->assertEquals($expected, $result);

        $rate = new Rate(['Package' => [$this->package, $this->package]]);
        $result = $rate->toArray();
        $expected = ['RateV4Request' => ['Revision' => 2, 'Package' => [0 => ['@ID' => '123', 'Service' => 'All', 'FirstClassMailType' => 'PARCEL', 'ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0.0, 'Ounces' => 32.0, 'Container' => 'VARIABLE', 'Size' => 'REGULAR', 'Machinable' => true], 1 => ['@ID' => '123', 'Service' => 'All', 'FirstClassMailType' => 'PARCEL', 'ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0.0, 'Ounces' => 32.0, 'Container' => 'VARIABLE', 'Size' => 'REGULAR', 'Machinable' => true]]]];
        $this->assertEquals($expected, $result);
    }

    public function testAddPackageFailure()
    {
        $rate = new Rate();
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        $rate->addPackage($this->package);
        try {
            $rate->addPackage($this->package);
        } catch (Exception $e) {
            $this->assertEquals('Package not added. You can only have a maximum of 25 packages included in each look up request.', $e->getMessage());
        }
    }

    public function testGetRate()
    {
        $rate = new Rate(['userID' => $_SERVER['USPS_USERID'], 'Package' => $this->package]);
        try {
            $result = $rate->getRate();
            $expected = [123 => ['ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0.0, 'Ounces' => 32.0, 'FirstClassMailType' => null, 'Container' => null, 'Size' => 'REGULAR', 'Width' => null, 'Length' => null, 'Height' => null, 'Girth' => null, 'Machinable' => true, 'Zone' => '8', 'Postage' => [0 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt;', 'Rate' => 12.75, '@CLASSID' => 1], 1 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Large Flat Rate Box', 'Rate' => 18.85, '@CLASSID' => 22], 2 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Medium Flat Rate Box', 'Rate' => 13.6, '@CLASSID' => 17], 3 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Small Flat Rate Box', 'Rate' => 7.15, '@CLASSID' => 28], 4 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Flat Rate Envelope', 'Rate' => 6.65, '@CLASSID' => 16], 5 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Legal Flat Rate Envelope', 'Rate' => 6.95, '@CLASSID' => 44], 6 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Padded Flat Rate Envelope', 'Rate' => 7.2, '@CLASSID' => 29], 7 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Gift Card Flat Rate Envelope', 'Rate' => 6.65, '@CLASSID' => 38], 8 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Small Flat Rate Envelope', 'Rate' => 6.65, '@CLASSID' => 42], 9 => ['MailService' => 'Priority Mail 2-Day&lt;sup&gt;&#8482;&lt;/sup&gt; Window Flat Rate Envelope', 'Rate' => 6.65, '@CLASSID' => 40], 10 => ['MailService' => 'USPS Retail Ground&lt;sup&gt;&#8482;&lt;/sup&gt;', 'Rate' => 12.21, '@CLASSID' => 4], 11 => ['MailService' => 'Media Mail Parcel', 'Rate' => 3.12, '@CLASSID' => 6], 12 => ['MailService' => 'Library Mail Parcel', 'Rate' => 2.97, '@CLASSID' => 7]]]];
            $this->assertEquals($expected, $result);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
}
