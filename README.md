        __  ___      ____  _     ___                           _                    __
       /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
      / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ / 
     / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /  
    /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/   
    
    CONFIDENTIAL
    
    © 2017 Multidimension.al - All Rights Reserved
    
    NOTICE:  All information contained herein is, and remains the property of
    Multidimension.al and its suppliers, if any.  The intellectual and
    technical concepts contained herein are proprietary to Multidimension.al
    and its suppliers and may be covered by U.S. and Foreign Patents, patents in
    process, and are protected by trade secret or copyright law. Dissemination
    of this information or reproduction of this material is strictly forbidden
    unless prior written permission is obtained.

### Address Example

There are multiple ways to create an Address object.

```php
//Method 1
$address1 = new Address([
    '@ID' => 1,
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
 
### AddressValidate Example

```php
use Multidimensional\USPS;

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