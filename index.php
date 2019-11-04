<?php

require __DIR__.'/vendor/autoload.php';

use ctwillie\Usps\Address;

// $address = new Address;
// $address->Address2  = '8448 Gatepost Court';
// $address->City = null;
// $address->State = null;
// $address->Zip5 = null;
// $address->verify();

$addr1 = [
    'Address2' => '4925 Spring Glen Road',
    'City' => 'Jacksonville',
    'State' => 'FL',
    'Zip5' => 32207,
];

$addr2 = [
    'Address1' => null,
    'Address2' => '8448 Gatepost Court',
    'City' => 'Jacksonville',
    'State' => 'FL',
    'Zip5' => 32244,
    'Zip4' => null
];

// complains about incomplete data
$addr3 = [
    'Address1' => null,
    'Address2' => null,
    'City' => null,
    'State' => null,
    'Zip5' => null,
    'Zip4' => null
];

$address = new Address($addr1);


echo $address->validate();