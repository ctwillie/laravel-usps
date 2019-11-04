<?php

namespace ctwillie\Usps;

use ctwillie\Usps\Address;

class Usps
{

    private $config;

    public function __construct(array $config) {

        $this->config = $config;

    }

    public function verifyAddress($address)
    {
        if ($address instanceof Address) {

            return $address->verify();
        
        } else {

            $address = new Address($address);

            return $address->verify();

        }

    }
    
}
