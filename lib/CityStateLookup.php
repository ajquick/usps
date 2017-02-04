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

use Multidimensional\Usps\Address;

class CityStateLookup extends Usps
{
       /**
     * @var string
     */
    private $apiClass = 'CityStateLookup';
    
    protected $addresses = [];
    
    public function __construct(array $config = [])
    {
        
    }
    
    public function addAddress(Address $address, $id = null)
    {
        
        if (is_null($id)) {
            $id = count($this->address) + 1;
        }
        
        $this->addresss[$id] = array_merge(['@attributes' => ['ID' => $id]], $address->toArray());
        
    }
    
}
