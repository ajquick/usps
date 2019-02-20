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

namespace Multidimensional\USPS;

use Multidimensional\USPS\IntlRate\Package;

class IntlRate extends USPS
{
    const FIELDS = [
        'IntlRateV2Request' => [
            'type' => 'array',
            'fields' => [
                '@USERID' => [
                    'type' => 'string',
                    'required' => true
                ],
                'Revision' => [
                    'type' => 'integer',
                    'values' => [2]
                ],
                'Package' => [
                    'type' => 'group',
                    'fields' => Package::FIELDS
                ]
            ]
        ]
    ];
    const RESPONSE = [];
    const ERROR_RESPONSE = [
        'Error' => [
            'type' => 'array',
            'fields' => [
                'Number' => [
                    'type' => 'string'
                ],
                'Source' => [
                    'type' => 'string'
                ],
                'Description' => [
                    'type' => 'string'
                ],
                'HelpFile' => [
                    'type' => 'string'
                ],
                'HelpContext' => [
                    'type' => 'string'
                ],
            ]
        ]
    ];
    public $revision = 2;
    protected $packages = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        if (isset($config['revision'])) {
            $this->setRevision($config['revision']);
        }

        $this->apiClass = 'IntlRateV2';
        $this->apiMethod = '';
    }

    public function setRevision($value)
    {
        if (intval($value) === 2) {
            $this->revision = '2';
        } else {
            $this->revision = null;
        }
    }

    public function getRate()
    {
        return $this->request($this->apiClass);
    }

    public function addPackage(IntlRate\Package $package)
    {
        $this->packages[] = $package->toArray();
    }
}
