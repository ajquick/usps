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

class AddressValidate extends Usps
{
    
    public $apiClass = 'Verify';
    
    protected $addresses = [];
    
    private $includeOptionalElements = false;
    private $returnCarrierRoute = false;
    
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
    
    public function setIncludeOptionalElements($boolean)
    {
        $this->includeOptionalElements = (boolean) $boolean;
    }
    
    public function setReturnCarrierRoute($boolean)
    {
        $this->returnCarrierRoute = (boolean) $boolean;
    }
    
    /**
     * @return array
     */
    private function buildArray()
    {
        $array = [];
        if ($this->includeOptionalElements === true) {
            $array['IncludeOptionalElements'] = 'true';
        }
        
        if ($this->returnCarrierRoute === true) {
            $array['ReturnCarrierRoute'] = 'true';
        }
        
        $array['Address'] = $this->addresses;
        
        return $array;
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return buildArray();
    }
    
    /**
     * @return array
     */
    public function validate()
    {
        $xml = $this->buildXML($this->toArray());
        if ($this->validateXML($xml, $this->apiClass)) {
            return $this->request($this->apiClass);
        }else{
            return false;    
        }
    }
}
