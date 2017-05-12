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
use Multidimensional\USPS\Track;
use PHPUnit\Framework\TestCase;

class TrackTest extends TestCase
{
    protected $trackingNumber;
    protected $trackingNumber2;
    protected $trackingNumber3;

    public function setUp()
    {
        $this->trackingNumber = 'EJ123456780US';
        $this->trackingNumber2 = 'EJ123456789US';
        $this->trackingNumber3 = 'EJ123456781US';
    }

    public function tearDown()
    {
        unset($this->trackingNumber);
        unset($this->trackingNumber2);
        unset($this->trackingNumber3);
    }

    public function testInitialize()
    {
        $track = new Track();
        $this->assertEmpty($track->toArray());
    }

    public function testSingleTrackIDInitialize()
    {
        $track = new Track(['TrackID' => $this->trackingNumber]);
        $result = $track->toArray();
        $expected = ['TrackRequest' => ['TrackID' => [0 => ['@ID' => 'EJ123456780US']]]];
        $this->assertEquals($expected, $result);
    }

    public function testMultiTrackIDInitialize()
    {
        $track = new Track(['TrackID' => [$this->trackingNumber, $this->trackingNumber2, $this->trackingNumber3]]);
        $result = $track->toArray();
        $expected = ['TrackRequest' => ['TrackID' => [0 => ['@ID' => 'EJ123456780US'], 1 => ['@ID' => 'EJ123456789US'], 2 => ['@ID' => 'EJ123456781US']]]];
        $this->assertEquals($expected, $result);
    }

    public function testAddTrackingNumber()
    {
        $track = new Track();
        $track->addTrackingNumber($this->trackingNumber);
        $result = $track->toArray();
        $expected = ['TrackRequest' => ['TrackID' => [0 => ['@ID' => 'EJ123456780US']]]];
        $this->assertEquals($expected, $result);
    }

    public function testTrack()
    {
        $track = new Track(['userID' => $_SERVER['USPS_USERID'], 'TrackID' => [$this->trackingNumber, $this->trackingNumber2, $this->trackingNumber3]]);
        try {
            $result = $track->track();
            $expected = ['EJ123456780US' => ['TrackSummary' => 'The Postal Service could not locate the tracking information for your request. Please verify your tracking number and try again later.', 'TrackDetail' => null], 'EJ123456789US' => ['TrackSummary' => 'The Postal Service could not locate the tracking information for your request. Please verify your tracking number and try again later.', 'TrackDetail' => null], 'EJ123456781US' => ['TrackSummary' => 'The Postal Service could not locate the tracking information for your request. Please verify your tracking number and try again later.', 'TrackDetail' => null]];
            $this->assertEquals($expected, $result);
        } catch (Exception $e) {
            $this->assertContains('Could not resolve host', $e->getMessage());
        }
    }

    public function testTooManyTrackingNumbers()
    {
        $track = new Track();
        $track->addTrackingNumber($this->trackingNumber);
        $track->addTrackingNumber($this->trackingNumber2);
        $track->addTrackingNumber($this->trackingNumber3);
        $track->addTrackingNumber($this->trackingNumber2 . '1');
        $track->addTrackingNumber($this->trackingNumber3 . '2');
        $track->addTrackingNumber($this->trackingNumber  . '3');
        $track->addTrackingNumber($this->trackingNumber2 . '4');
        $track->addTrackingNumber($this->trackingNumber3 . '5');
        $track->addTrackingNumber($this->trackingNumber  . '6');
        $track->addTrackingNumber($this->trackingNumber2 . '7');
        try {
            $track->addTrackingNumber($this->trackingNumber3 . '8');
        } catch (Exception $e) {
            $this->assertEquals('Tracking number not added. You can only have a maximum of 10 tracking numbers included in each look up request.', $e->getMessage());
        }
    }

    public function testAPIResponse()
    {
        $xml = '<TrackResponse><TrackInfo ID="XXXXXXXXXXXX1"><TrackSummary>Your item was delivered at 6:50 am on February 6 in BARTOW FL 33830.</TrackSummary><TrackDetail>February 6 6:49 am NOTICE LEFT BARTOW FL 33830</TrackDetail><TrackDetail>February 6 6:48 am ARRIVAL AT UNIT BARTOW FL 33830</TrackDetail><TrackDetail>February 6 3:49 am ARRIVAL AT UNIT LAKELAND FL 33805</TrackDetail><TrackDetail>February 5 7:28 pm ENROUTE 33699</TrackDetail><TrackDetail>February 5 7:18 pm ACCEPT OR PICKUP 33699</TrackDetail></TrackInfo><TrackInfo ID="XXXXXXXXXXXX2"><TrackSummary>There is no record of that mail item. If it was mailed recently, It may not yet be tracked. Please try again later. </TrackSummary></TrackInfo><TrackInfo ID="XXXXXXXXXXXX3"><TrackSummary> That\'s not a valid number. Please check to make sure you entered it correctly.</TrackSummary></TrackInfo></TrackResponse>';
        $method = self::getMethod('parseResult');
        $track = new Track();
        $result = $method->invokeArgs($track, [$xml]);
        $expected = ['XXXXXXXXXXXX1' => ['TrackSummary' => 'Your item was delivered at 6:50 am on February 6 in BARTOW FL 33830.', 'TrackDetail' => [0 => 'February 6 6:49 am NOTICE LEFT BARTOW FL 33830',1 => 'February 6 6:48 am ARRIVAL AT UNIT BARTOW FL 33830',2 => 'February 6 3:49 am ARRIVAL AT UNIT LAKELAND FL 33805',3 => 'February 5 7:28 pm ENROUTE 33699',4 => 'February 5 7:18 pm ACCEPT OR PICKUP 33699']], 'XXXXXXXXXXXX2' => ['TrackSummary' => 'There is no record of that mail item. If it was mailed recently, It may not yet be tracked. Please try again later. ', 'TrackDetail' => null], 'XXXXXXXXXXXX3' => ['TrackSummary' => ' That&#39;s not a valid number. Please check to make sure you entered it correctly.', 'TrackDetail' => null]];
        $this->assertEquals($expected, $result);
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass('Multidimensional\Usps\Track');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
