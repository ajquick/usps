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