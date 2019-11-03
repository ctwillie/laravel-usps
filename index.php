<?php

require __DIR__.'/vendor/autoload.php';

use ctwillie\Usps\Address;

// $address = new Address;
// $address->address2  = '8448 Gatepost Court';
// $address->city = 'Jacksonville';
// $address->state = 'FL';
// $address->zip5 = 32207;

$add1 = [
    "address2" => '4925 Spring Glen Road',
    "city" => 'Jacksonville',
    "state" => 'FL',
    "zip5" => 32207
];

$add2 = [
    "address2" => '8 Gatepost Court',
    "city" => 'Jacksonville',
    "state" => 'FL',
    "zip5" => 32244
];

$address = new Address($add2);

echo $address->verify();







exit();