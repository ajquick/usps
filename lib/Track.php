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

namespace Multidimensional\Usps;

use Multidimensional\Usps\Exception\TrackException;

class Track extends USPS
{
    /**
     * @var string
     */
    protected $apiClass = 'TrackV2';
    protected $apiMethod = 'TrackRequest';

    /**
     * @var array
     */
    protected $trackingNumbers = [];

    const FIELDS = [
        'TrackRequest' => [
            'type' => 'group',
            'fields' => [
                'TrackID' => [
                    'type' => 'array',
                    'fields' => [
                        '@ID' => [
                            'type' => 'string',
                            'required' => true
                        ]
                    ]
                ]
            ]
        ]
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        if (is_array($config) && isset($config['TrackID'])) {
            if (is_array($config['TrackID'])) {
                foreach ($config['TrackID'] as $trackID) {
                    $this->addTrackingNumber($trackID);
                }
            } else {
                $this->addTrackingNumber($config['TrackID']);
            }
        }
    }

    /**
     * @param string $string
     */
    public function addTrackingNumber($value)
    {
        if (count($this->trackingNumbers) < 10) {
            $this->trackingNumbers[] = $value;
        } else {
            throw new TrackException('Tracking number not added. You can only have a maximum of 10 tracking numbers included in each look up request.');
        }
    }

    /**
     * @return array
     */
    public function track()
    {
        $xml = $this->buildXML($this->toArray());
        if ($this->validateXML($xml)) {
            $result = $this->request($xml);
            return $this->parseResult($result);
        } else {
            throw new TrackException('Unable to validate XML.');
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        if (is_array($this->trackingNumbers) && count($this->trackingNumbers)) {
            foreach ($this->trackingNumbers as $trackingNumber) {
                $array['TrackRequest']['TrackID'][]['@ID'] = $trackingNumber;
            }
        }
        return $array;
    }
}
