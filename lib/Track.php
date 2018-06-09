<?php
/**
 *     __  ___      ____  _     ___                           _                    __
 *    /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *   / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *  / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 * /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * @author Multidimension.al
 * @copyright Copyright © 2016-2018 Multidimension.al - All Rights Reserved
 * @license Proprietary and Confidential
 *
 * NOTICE:  All information contained herein is, and remains the property of
 * Multidimension.al and its suppliers, if any.  The intellectual and
 * technical concepts contained herein are proprietary to Multidimension.al
 * and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law. Dissemination
 * of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained.
 */

namespace Multidimensional\USPS;

use Exception;
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class Track extends USPS
{
    const FIELDS = [
        'TrackRequest' => [
            'type' => 'array',
            'fields' => [
                'TrackID' => [
                    'type' => 'group',
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
    const RESPONSE = [
        'TrackResponse' => [
            'type' => 'array',
            'fields' => [
                'TrackInfo' => [
                    'type' => 'group',
                    'fields' => [
                        '@ID' => [
                            'type' => 'string'
                        ],
                        'TrackSummary' => [
                            'type' => 'string'
                        ],
                        'TrackDetail' => [
                            'type' => 'group',
                            'fields' => []
                        ]
                    ]
                ]
            ]
        ]
    ];
    protected $trackingNumbers = [];

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

        $this->apiClass = 'TrackV2';
        $this->apiMethod = 'TrackRequest';
    }

    /**
     * @param $value
     * @throws Exception
     */
    public function addTrackingNumber($value)
    {
        if (count($this->trackingNumbers) < 10) {
            $this->trackingNumbers[] = $value;
        } else {
            throw new Exception('Tracking number not added. You can only have a maximum of 10 tracking numbers included in each look up request.');
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function track()
    {
        $xml = $this->buildXML($this->toArray());
        if ($this->validateXML($xml)) {
            try {
                $result = $this->request($xml);
                return $this->parseResult($result);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            throw new Exception('Unable to validate XML.');
        }
    }

    /**
     * @return array|null
     */
    public function toArray()
    {
        $array = [];
        if (is_array($this->trackingNumbers) && count($this->trackingNumbers)) {
            foreach ($this->trackingNumbers as $trackingNumber) {
                $array['TrackRequest']['TrackID'][]['@ID'] = $trackingNumber;
            }
        }
        try {
            if (is_array($array) && count($array)) {
                Validation::validate($array, self::FIELDS);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $array;
    }

    /**
     * @param string $result
     * @return array
     */
    protected function parseResult($result)
    {
        $array = parent::parseResult($result);
        $array = Sanitization::sanitize($array, self::RESPONSE);

        try {
            if (is_array($array) && count($array)) {
                Validation::validate($array, self::RESPONSE);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }

        $array = $array['TrackResponse'];

        if (is_array($array) && count($array) && (isset($array['TrackInfo']) || array_key_exists('TrackInfo', $array))) {
            $array = $array['TrackInfo'];

            foreach ($array as $key => $value) {
                if (is_int($key)) {
                    $array[$value['@ID']] = $value;
                    unset($array[$key]);
                } else {
                    $array2[$array['@ID']] = $array;
                    $array = $array2;
                    break;
                }
            }

            foreach ($array as $key => $value) {
                $array[$key] += array_combine(array_keys(self::RESPONSE['TrackResponse']['fields']['TrackInfo']['fields']), array_fill(0, count(self::RESPONSE['TrackResponse']['fields']['TrackInfo']['fields']), null));
                $array[$key] = array_replace(self::RESPONSE['TrackResponse']['fields']['TrackInfo']['fields'], $array[$key]);
                unset($array[$key]['@ID']);
            }

            return $array;
        }

        throw new Exception();
    }
}
