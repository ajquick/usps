<?php
/**    __  ___      ____  _     ___                           _                    __
 *    /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *   / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ / 
 *  / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /  
 * /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/   
 *                                                                                  
 * CONFIDENTIAL
 *
 * © 2017 Multidimension.al - All Rights Reserved
 * 
 * NOTICE:  All information contained herein is, and remains the property of
 * Multidimension.al and its suppliers, if any.  The intellectual and
 * technical concepts contained herein are proprietary to Multidimension.al
 * and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law. Dissemination
 * of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained.
 */

namespace Multidimensional\Usps\Test\Rate;

use Multidimensional\Usps\Rate\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    public function testNamedFunctions()
    {
        $this->markTestIncomplete();
        /*
        $package = new Package();
        $package->setService();
        $package->setFirstClassMailType();
        $package->setZipOrigination();
        $package->setZipDestination();
        $package->setPounds();
        $package->setOunces();
        $package->setSize();
        $package->setContainer();
        $package->setWidth();
        $package->setLength();
        $package->setHeight();
        $package->setGirth();
        $package->setValue();
        $package->setAmountToCollect();
        $package->setGroundOnly();
        $package->setSortBy();
        $package->setMachinable();
        */
    }
    
    public function testConstants()
    {
        $this->assertEqual('VARIABLE', Package::CONTAINER_VARIABLE);
        $this->assertEqual('FLAT RATE ENVELOPE', Package::CONTAINER_FLAT_RATE_ENVELOPE );
        $this->assertEqual('PADDED FLAT RATE ENVELOPE', Package::CONTAINER_PADDED_FLAT_RATE_ENVELOPE);
        $this->assertEqual('LEGAL FLAT RATE ENVELOPE', Package::CONTAINER_LEGAL_FLAT_RATE_ENVELOPE);
        $this->assertEqual('SM FLAT RATE ENVELOPE', Package::CONTAINER_SM_FLAT_RATE_ENVELOPE);
        $this->assertEqual('WINDOW FLAT RATE ENVELOPE', Package::CONTAINER_WINDOW_FLAT_RATE_ENVELOPE);
        $this->assertEqual('GIFT CARD FLAT RATE ENVELOPE', Package::CONTAINER_GIFT_CARD_FLAT_RATE_ENVELOPE);
        $this->assertEqual('FLAT RATE BOX', Package::CONTAINER_FLAT_RATE_BOX);
        $this->assertEqual('SM FLAT RATE BOX', Package::CONTAINER_SM_FLAT_RATE_BOX);
        $this->assertEqual('MD FLAT RATE BOX', Package::CONTAINER_MD_FLAT_RATE_BOX);
        $this->assertEqual('LG FLAT RATE BOX', Package::CONTAINER_LG_FLAT_RATE_BOX);
        $this->assertEqual('REGIONALRATEBOXA', Package::CONTAINER_REGIONALRATEBOXA);
        $this->assertEqual('REGIONALRATEBOXB', Package::CONTAINER_REGIONALRATEBOXB);
        $this->assertEqual('RECTANGULAR', Package::CONTAINER_RECTANGULAR);
        $this->assertEqual('NONRECTANGULAR', Package::CONTAINER_NONRECTANGULAR );
        $this->assertEqual('LETTER', Package::FIRST_CLASS_MAIL_TYPE_LETTER );
        $this->assertEqual('FLAT', Package::FIRST_CLASS_MAIL_TYPE_FLAT);
        $this->assertEqual('PARCEL', Package::FIRST_CLASS_MAIL_TYPE_PARCEL );
        $this->assertEqual('POSTCARD', Package::FIRST_CLASS_MAIL_TYPE_POSTCARD);
        $this->assertEqual('PACKAGE', Package::FIRST_CLASS_MAIL_TYPE_PACKAGE);
        $this->assertEqual('PACKAGE SERVICE', Package::FIRST_CLASS_MAIL_TYPE_PACKAGE_SERVICE);
        $this->assertEqual('First Class', Package::SERVICE_FIRST_CLASS);
        $this->assertEqual('First Class Commercial', Package::SERVICE_FIRST_CLASS_COMMERCIAL);
        $this->assertEqual('First Class HFP Commercial', Package::SERVICE_FIRST_CLASS_HFP_COMMERCIAL);
        $this->assertEqual('Priority', Package::SERVICE_PRIORITY );
        $this->assertEqual('Priority Commercial', Package::SERVICE_PRIORITY_COMMERCIAL);
        $this->assertEqual('Priority Cpp', Package::SERVICE_PRIORITY_CPP );
        $this->assertEqual('Priority HFP Commercial', Package::SERVICE_PRIORITY_HFP_COMMERCIAL);
        $this->assertEqual('Priority HFP CPP', Package::SERVICE_PRIORITY_HFP_CPP );
        $this->assertEqual('Priority Mail Express', Package::SERVICE_PRIORITY_EXPRESS );
        $this->assertEqual('Priority Mail Express Commercial', Package::SERVICE_PRIORITY_EXPRESS_COMMERCIAL);
        $this->assertEqual('Priority Mail Express CPP', Package::SERVICE_PRIORITY_EXPRESS_CPP );
        $this->assertEqual('Priority Mail Express SH', Package::SERVICE_PRIORITY_EXPRESS_SH);
        $this->assertEqual('Priority Mail Express SH COMMERCIAL', Package::SERVICE_PRIORITY_EXPRESS_SH_COMMERCIAL);
        $this->assertEqual('Priority Mail Express HFP', Package::SERVICE_PRIORITY_EXPRESS_HFP );
        $this->assertEqual('Priority Mail Express HFP COMMERCIAL', Package::SERVICE_PRIORITY_EXPRESS_HFP_COMMERCIAL);
        $this->assertEqual('Priority Mail Express HFP CPP', Package::SERVICE_PRIORITY_EXPRESS_HFP_CPP );
        $this->assertEqual('Retail Ground', Package::SERVICE_GROUND);
        $this->assertEqual('Media', Package::SERVICE_MEDIA);
        $this->assertEqual('Library', Package::SERVICE_LIBRARY);
        $this->assertEqual('All', Package::SERVICE_ALL);
        $this->assertEqual('Online', Package::SERVICE_ONLINE);
        $this->assertEqual('Plus', Package::SERVICE_PLUS );
        $this->assertEqual('LARGE', Package::SIZE_LARGE);
        $this->assertEqual('REGULAR', Package::SIZE_REGULAR );    
    }
}
