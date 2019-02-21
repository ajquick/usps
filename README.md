# USPS API PHP Library

[![Build Status](https://travis-ci.org/multidimension-al/usps.svg)](https://travis-ci.org/multidimension-al/usps)
[![Latest Stable Version](https://poser.pugx.org/multidimensional/usps/v/stable.svg)](https://packagist.org/packages/multidimensional/usps)
[![Code Coverage](https://scrutinizer-ci.com/g/multidimension-al/usps/badges/coverage.png)](https://scrutinizer-ci.com/g/multidimension-al/usps/)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.5-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/multidimensional/usps/license.svg)](https://packagist.org/packages/multidimensional/usps)
[![Total Downloads](https://poser.pugx.org/multidimensional/usps/d/total.svg)](https://packagist.org/packages/multidimensional/usps)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/multidimension-al/usps/badges/quality-score.png)](https://scrutinizer-ci.com/g/multidimension-al/usps/)

## Requirements

* PHP 5.6+
* [Array Validation Library](https://github.com/multidimension-al/array-validation)
* [Array Sanitization Library](https://github.com/multidimension-al/array-sanitization)
* [DOM Array Library](https://github.com/multidimension-al/dom-array)
* [XML Array Library](https://github.com/multidimension-al/xml-array)

### Address Object Example

There are multiple ways to create an Address object.

```php
//Method 1
$address1 = new Address([
    'ID' => 1,
    'Address2' => '123 Fake St.',
    'City' => 'Springfield',
    'State' => 'CA',
    'Zip4' => 90210
]);

//Method 2
$address2 = new Address();

$address2->setID('1');
$address2->setAddress2('123 Fake St.');
$address2->setCity('Springfield');
$address2->setState('CA');
$address2->setZip4(90210);
```

Both methods can be used, and address objects can be updated or overridden on the fly using the 'set' methods.
 
### ZipCode Object Example

There are multiple ways to make a ZipCode object.

```php
//Method 1
$zipCode = new ZipCode(['ID' => 123, 'Zip5' => '90210']);

//Method 2
$zipCode = new ZipCode();
$zipCode->setID(123);
$zipCode->setZip5(90210)
```
 
Both methods can be used, and ZipCode objects can be updated or overridden on the fly using the 'set' methods.
  
 
### AddressValidate Example

AddressValidate is a USPS API method that will confirm or correct a submitted address. Up to 5 addresses can be added and validated at one time.

```php
$address = new Address([
    '@ID' => 1,
    'Address2' => '123 Fake St.',
    'City' => 'Springfield',
    'State' => 'CA',
    'Zip4' => 90210
]);
$addressValidate = new AddressValidate();
$addressValidate->addAddress($address);

$response = $addressValidate->validate();

if ($addressValidate->isSuccess()) {

    //do stuff

} else {
    
    $addressValidate->getErrorMessage();

}
```

The response will include the corrected address, but may also return possible other addresses if the address is not 100% valid.

### CityStateLookup Example

CityStateLookup is a USPS API method for looking up the city and state when provided with a ZipCode object.

```php
$zipCode = new ZipCode(['ID' => 123, 'Zip5' => 20500]);
$cityStateLookup = new CityStateLookup(['userID' => $_SERVER['USPS_USERID']]);
$cityStateLookup->addZipCode($zipCode);
$result = $cityStateLookup->lookup();
```

The result includes City and State information that can be referenced back to the ID included with the ZipCode object.

### ZipCodeLookup Example

```php
$address = new Address([
    '@ID' => 1,
    'Address2' => '123 Fake St.',
    'City' => 'Springfield',
    'State' => 'CA',
    'Zip4' => 90210
]);
$zipCodeLookup = new ZipCodeLookup();
$zipCodeLookup->addAddress($address);
$result = $zipCodeLookup->lookup();
```

The results provided will return a ZipCode and a +4 Code if it is available.

### Track Example

```php
$track = new Track('TrackID' => '940000000000000012345');
$result = $track->track();
```

The results provided will be a summary of the tracking information as well as a step by step listing of all the details.

# License

         __  ___      ____  _     ___                           _                    __
        /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
       / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
      / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
     /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
  
    USPS API PHP Library
    Copyright (c) Multidimension.al (http://multidimension.al)
    Github : https://github.com/multidimension-al/usps
  
    Licensed under The MIT License
    For full copyright and license information, please see the LICENSE file
    Redistributions of files must retain the above copyright notice.
  
    @copyright  Copyright © 2017-2019 Multidimension.al (http://multidimension.al)
    @link       https://github.com/multidimension-al/usps Github
    @license    http://www.opensource.org/licenses/mit-license.php MIT License
