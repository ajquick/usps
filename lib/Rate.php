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

class Rate extends Usps
{
    /**
     * @var string
     */
    private $apiClass = 'RateV4';
    
    /**
     * @var array
     */
    protected $packages = [];
    
    private $revision = 2;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        if (isset($config['revision'])) {
            $this->setRevision($config['revision']);    
        }
    }
    
    public function getRate()
    {
        return $this->request($this->apiClass);    
    }
    
    public function addPackage(RateV4Package $package)
    {        
        $this->packages[] = $package->toArray();   
    }
    
    public function setRevision($value)
    {
        if ($value == 2) {
            $this->revision = '2';
        } else {
            $this->revision = null;    
        }
    }

}
