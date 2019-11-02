<?php

namespace ctwillie\USPS;

use Spatie\ArrayToXml\ArrayToXml;

class Address {

    public $address1 = "";
    public $address2 = "";
    public $city = "";
    public $state = "";
    public $zip4 = "";
    public $zip5 = "";

    private $userId = 'XXXXXXXXX';
    // ArrayToXml::convert($array, $rootElem, false)
    // http://stg-production.shippingapis.com/ShippingApi.dll?
    // API=Verify&
    // XML=<AddressValidateRequest USERID="XXXXXXXX">

    public function __construct(array $address = [])
    {
        foreach($address as $key => $value) {

            if (property_exists($this, $key)) {

                $this->{$key} = $value;

            }
        
        }
    }

    public function createXMLAddress()
    {
        $addressArray = [

            "Address" => [

                "Address1" => $this->address1,

                "Address2" => $this->address2,

                "City" => $this->city,

                "State" => $this->state,

                "Zip5" => $this->zip5,

                "Zip4" => $this->zip4

            ]
        ];

        return ArrayToXml::convert($addressArray,
            [
                'rootElementName' => 'AddressValidateRequest',

                '_attributes' => ['USERID' => $this->userId]

            ], false);
    }
    
    public function verify()
    {
        $addressXML = urlencode($this->createXMLAddress());

        $url = "https://secure.shippingapis.com/ShippingAPI.dll?API=Verify&XML=" . $addressXML;

        return file_get_contents($url);
    }
}





