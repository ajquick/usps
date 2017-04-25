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

namespace Multidimensional\Usps\Test;

use Multidimensional\Usps\Exception\TrackException;
use Multidimensional\Usps\Track;
use PHPUnit\Framework\TestCase;

class TrackTest extends TestCase
{
    protected $track;
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
        $this->track = new Track();
        $this->assertEmpty($this->track->toArray());
    }

    public function testSingleTrackIDInitialize()
    {
        $this->track = new Track(['TrackID' => $this->trackingNumber]);
        $result = $this->track->toArray();
        $expected = ['TrackRequest' => ['TrackID' => [0 => ['@ID' => 'EJ123456780US']]]];
        $this->assertEquals($expected, $result);
    }

    public function testMultiTrackIDInitialize()
    {
        $this->track = new Track(['TrackID' => [$this->trackingNumber, $this->trackingNumber2, $this->trackingNumber3]]);
        $result = $this->track->toArray();
        $expected = ['TrackRequest' => ['TrackID' => [0 => ['@ID' => 'EJ123456780US'], 1 => ['@ID' => 'EJ123456789US'], 2 => ['@ID' => 'EJ123456781US']]]];
        $this->assertEquals($expected, $result);
    }

    public function testAddTrackingNumber()
    {
        $this->track = new Track();
        $this->track->addTrackingNumber($this->trackingNumber);
        $result = $this->track->toArray();
        $expected = ['TrackRequest' => ['TrackID' => [0 => ['@ID' => 'EJ123456780US']]]];
        $this->assertEquals($expected, $result);
    }

    public function testTrack()
    {
        $this->track = new Track(['TrackID' => [$this->trackingNumber, $this->trackingNumber2, $this->trackingNumber3]]);
        $result = $this->track->track();
        var_export($result);
    }

    public function testFailure()
    {
        $this->markTestIncomplete('Not yet implemented.');
    }

    public function testTooManyTrackingNumbers()
    {
        $this->track = new Track();
        $this->track->addTrackingNumber($this->trackingNumber);
        $this->track->addTrackingNumber($this->trackingNumber2);
        $this->track->addTrackingNumber($this->trackingNumber3);
        $this->track->addTrackingNumber($this->trackingNumber2 . '1');
        $this->track->addTrackingNumber($this->trackingNumber3 . '2');
        $this->track->addTrackingNumber($this->trackingNumber  . '3');
        $this->track->addTrackingNumber($this->trackingNumber2 . '4');
        $this->track->addTrackingNumber($this->trackingNumber3 . '5');
        $this->track->addTrackingNumber($this->trackingNumber  . '6');
        $this->track->addTrackingNumber($this->trackingNumber2 . '7');
        try {
            $this->track->addTrackingNumber($this->trackingNumber3 . '8');
        } catch (TrackException $e) {
            $this->assertEquals('Tracking number not added. You can only have a maximum of 10 tracking numbers included in each look up request.', $e->getMessage());
        }
    }
}
