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

use Exception;
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class ZipCode
{

    const FIELDS = [
        '@ID' => [
            'type' => 'integer',
            'required' => true
        ],
        'Zip5' => [
            'type' => 'string',
            'required' => true,
            'pattern' => '\d{5}'
        ]
    ];
    protected $zipCode = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            if (isset($config['ID'])) {
                $config['@ID'] = $config['ID'];
                unset($config['ID']);
            }
            foreach ($config as $key => $value) {
                $this->setField($key, $value);
            }
        }
        $this->zipCode += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), null));

        return;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($value, self::FIELDS[$key]);
            $this->zipCode[$key] = $value;
        }

        return;
    }


    /**
     * @param int $value
     * @return void
     */
    public function setID($value)
    {
        $this->setField('@ID', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setZip5($value)
    {
        $this->setField('Zip5', $value);

        return;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function toArray()
    {
        try {
            if (is_array($this->zipCode) && count($this->zipCode)) {
                Validation::validate($this->zipCode, self::FIELDS);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $this->zipCode;
    }
}
