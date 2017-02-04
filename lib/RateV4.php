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

use Multidimensional\Usps\RateV4Package;

class RateV4 extends Usps
{
    /**
     * @var string
     */
    private $apiClass = 'RateV4';
    
    /**
     * @var array
     */
    protected $packages = [];

    public function __construct(array $config = [])
    {
        
    }
    
    public function addPackage(RateV4Package $package, $id = null)
    {
        
        if (is_null($id)) {
            $id = count($this->packages) + 1;
        }
        
        $this->packages[$id] = array_merge(['@attributes' => ['ID' => $id]], $package->toArray());
        
    }

}
