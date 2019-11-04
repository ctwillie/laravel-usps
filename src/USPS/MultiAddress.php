<?php

namespace ctwillie\Usps;

use Spatie\ArrayToXml\ArrayToXml;
use GuzzleHttp\Client;

class MultiAddress {

    // ArrayToXml::convert($array, $rootElem, false)
    // http://stg-production.shippingapis.com/ShippingApi.dll?
    // API=Verify&
    // XML=<AddressValidateRequest USERID="XXXXXXXX">
    public $address1 = '';
    public $address2 = '';
    public $city = '';
    public $state = '';
    public $zip4 = '';
    public $zip5 = '';
    protected $addresses = [];
    protected $apiType = 'Verify';
    private $USERID = '645NFS002225';
    protected $allowedProperties = [
        'Address1',
        'Address2',
        'City',
        'State',
        'Zip4',
        'Zip5'
    ];

    public function debug($value)
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    }

    public function __construct(array $addresses = [])
    {

        if (array_key_exists(0, $addresses)) {

            foreach ($addresses as $index => $address) {

                // check for 5 address limit
                if (count($this->addresses) === 5) {
                    throw new \Exception('Only five addresses can be verified per request');
                }

                if ((bool) count($address)) {

                    $this->addresses[$index] = [];
                    $this->addresses[$index]['_attributes'] = ['ID' => $index + 1];

                    foreach ($address as $key => $value) {

                        if (in_array($key, $this->allowedProperties)) {

                            $this->addresses[$index][$key] = $value;
                        }
                    }
                }
            }
        
        } else {

            $index = count($this->addresses);

            foreach($addresses as $key => $value) {

                if (in_array($key, $this->allowedProperties)) {

                    $this->addresses[$index][$key] = $value;

                }
            }
        }
    }

    public function convertToXml()
    {
        return ArrayToXml::convert(
            ['Address' => $this->addresses],
            [
                'rootElementName' => 'AddressValidateRequest',

                '_attributes' => ['USERID' => $this->USERID]

            ],
            false
        );
    }

    public function verify()
    {
        $addressXML = urlencode($this->convertToXml());
        $client = new Client(['base_uri' => 'https://secure.shippingapis.com/', 'verify' => false]);
        $response =  $client->request(
            'GET', 
            "ShippingAPI.dll?API=Verify&XML=$addressXML"
        );

        return $response->getBody();
    }
   
}