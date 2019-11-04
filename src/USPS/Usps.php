<?php

namespace ctwillie\Usps;

use ctwillie\Usps\Address;

class Usps
{

    private $config;

    public function __construct(array $config) {

        $this->config = $config;

    }

    public function validateAddress($address)
    {
        if ($address instanceof Address) {

            return $address->validate();
        
        } else {

            $address = new Address($address);

            return $address->validate();

        }

    }
    
}
