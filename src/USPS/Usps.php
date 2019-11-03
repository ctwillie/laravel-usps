<?php

namespace ctwillie\Usps;

use ctwillie\Usps\Address;

class Usps
{

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
