<?

class Notes {

    protected $production = 'http://production.shippingapis.com/ShippingAPI.dll?API=Verify&XML=($address)';
    protected $secure = 'https://secure.shippingapis.com/ShippingAPI.dll?API=Verify&XML=($address)';

    public function createAddressArray($address, $index)
    {
        return [
            "Address" => [
                "_attributes" => ["ID" => $index + 1],
                "Address1" => array_key_exists('address1', $address) ? $address['address1'] : null,
                "Address2" => array_key_exists('address2', $address) ? $address['address2'] : null,
                "City" => array_key_exists('city', $address) ? $address['city'] : null,
                "State" => array_key_exists('state', $address) ? $address['state'] : null,
                "Zip5" => array_key_exists('zip5', $address) ? $address['zip5'] : null,
                "Zip4" => array_key_exists('zip4', $address) ? $address['zip4'] : null
            ]
        ];
    }

    public function notes()
    {
        $addresses = [[
            "_attributes" => ["ID" => 1],
            "Address1" => null,
            "Address2" => '4925 Spring Glen Rd',
            "City" => 'Jacksonville',
            "State" => 'FL',
            "Zip5" => 32207,
            "Zip4" => null
        ], [
            "_attributes" => ["ID" => 2],
            "Address1" => null,
            "Address2" => '8448 Gatepost Court',
            "City" => 'Jacksonville',
            "State" => 'FL',
            "Zip5" => 32244,
            "Zip4" => null
        ]];
    }

    /**
     * 
     * The Address Standardization Web Tool corrects errors in street addresses, 
     * including abbreviations and missing information, 
     * and supplies ZIP Codes and ZIP Codes + 4.  It supports up to five lookups per transaction.  
     * By eliminating address errors, you will improve overall package delivery service.
     * 
     */

    // public function verify()
    // {
    //     $addressXML = urlencode($this->createXMLAddress());
    //     $url = "https://secure.shippingapis.com/ShippingAPI.dll?API=Verify&XML=" . $addressXML;
    //     return file_get_contents($url);
    // }

    
    // $xml = simplexml_load_string($address->verify());
    // $json = json_encode($xml);
    // $array = json_decode($json, true);


}