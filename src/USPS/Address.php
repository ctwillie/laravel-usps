<?php

namespace ctwillie\Usps;

use Spatie\ArrayToXml\ArrayToXml;
use GuzzleHttp\Client;

class Address
{
    public $address1 = "";
    public $address2 = "";
    public $city = "";
    public $state = "";
    public $zip4 = "";
    public $zip5 = "";
    private $userId = '645NFS002225';

    public function __construct(array $address = [])
    {
        foreach ($address as $key => $value) {

            if (property_exists($this, $key)) {

                $this->{$key} = $value;
                
            }
        }
    }
    public function createXMLAddress()
    {
        $addressArray = [

            "Address" => [

                "_attributes" => ["ID" => "1"],

                "Address1" => $this->address1,

                "Address2" => $this->address2,

                "City" => $this->city,

                "State" => $this->state,

                "Zip5" => $this->zip5,

                "Zip4" => $this->zip4

            ]
        ];

        return ArrayToXml::convert(
            $addressArray,
            [
                'rootElementName' => 'AddressValidateRequest',
                
                '_attributes' => ['USERID' => $this->userId]

            ], false
        );
    }

    public function verify()
    {
        $addressXML = urlencode($this->createXMLAddress());

        $client = new Client(['base_uri' => 'https://secure.shippingapis.com/', 'verify' => false]);

        $response =  $client->request(

            'GET',

            "ShippingAPI.dll?API=Verify&XML=$addressXML"

        );

        $body = $response->getBody();

        // var_dump(get_class_methods($body));
        var_dump(gettype($body->getContents()));
        // echo $body->getContents();
         

        exit();
        // HANDLING GUZZLE RESPONSE
        // $response->getStatusCode();
        // $response->getReasonPhrase();
        // $response->hasHeader('Content-Length')
        // $response->getHeader('Content-Length');
        //  $response->getHeaders() as $name => $values


    }
}
