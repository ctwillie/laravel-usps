<?php

require __DIR__.'/vendor/autoload.php';

use ctwillie\USPS\Address;

// $address = new Address;
// $address->address2  = '8448 Gatepost Court';
// $address->city = 'Jacksonville';
// $address->state = 'FL';
// $address->zip5 = 32207;


$address = new Address([
    "address2" => '4925 Spring Glen Road',
    "city" => 'Jacksonville',
    "state" => 'FL',
    "zip5" => 32207
]);

echo $address->verify();







exit();