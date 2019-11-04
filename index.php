<?php

require __DIR__.'/vendor/autoload.php';

use ctwillie\Usps\MultiAddress;

// $address = new Address;
// $address->Address2  = '8448 Gatepost Court';
// $address->City = 'Jacksonville';
// $address->State = 'FL';
// $address->Zip5 = 32207;
// $address->verify();

$addr1 = [
    "Address1" => null,
    "Address2" => '4925 Spring Glen Road',
    "City" => 'Jacksonville',
    "State" => 'FL',
    "Zip5" => 32207,
    "Zip4" => null
];

$addr2 = [
    "Address1" => null,
    "Address2" => '8448 Gatepost Court',
    "City" => 'Jacksonville',
    "State" => 'FL',
    "Zip5" => 32244,
    "Zip4" => null
];

$address = new MultiAddress([$addr2, $addr1]);

echo $address->verify();