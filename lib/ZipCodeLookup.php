<?php
/**
 * CONFIDENTIAL
 *
 * © 2017 Multidimension.al - All Rights Reserved
 * 
 * NOTICE:  All information contained herein is, and remains
 * the property of Multidimension.al and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to Multidimension.al and its suppliers
 * and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained.
 */

namespace Multidimensional\Usps;

use Multidimensional\Usps\ZipCode;

class ZipCodeLookup extends Usps
{
    /**
     * @var string
     */
    private $apiClass = 'ZipCodeLookup';
    
    protected $addresses = [];
    
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
    
    /**
     * @param Address $address
     * @return true|false
     */
    public function addAddress(Address $address)
    {
        if (count($this->addresses) < 5) {
            $this->addresses[] = $address->toArray();   
            return true;
        } else {
            return false;    
        }
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->addresses;
    }
    
}
