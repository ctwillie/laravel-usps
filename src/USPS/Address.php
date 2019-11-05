<?php

namespace ctwillie\Usps;

use Spatie\ArrayToXml\ArrayToXml;
use GuzzleHttp\Client;

class Address
{
    protected $addresses = [];
    protected $allowedProperties = [
        'Address1',
        'Address2',
        'City',
        'State',
        'Zip4',
        'Zip5'
    ];
    protected $addressTemplate = [
        '_attributes' => [],
        'Address1' => '',
        'Address2' => '',
        'City' => '',
        'State' => '',
        'Zip5' => '',
        'Zip4' => ''
    ];

    public function __construct(array $addresses = [])
    {
        // Process array of addresses
        if (array_key_exists(0, $addresses)) {

            foreach ($addresses as $index => $address) {

                // check for 5 address limit
                if (count($this->addresses) === 5) {
                    throw new \Exception('USPS: Only five addresses can be validated per request.');
                }

                // Set to address template
                $this->addresses[$index] = $this->addressTemplate;
                // set address fields
                $this->addresses[$index]['_attributes'] = ['ID' => $index + 1];

                foreach ($address as $key => $value) {

                    if (in_array($key, $this->allowedProperties)) {

                        $this->addresses[$index][$key] = $value;
                    }
                }
            }
        } else {

            // Process single address
            $index = 0;
            // Set to address template
            $this->addresses[$index] = $this->addressTemplate;
            // reset address fields
            $this->addresses[$index]['_attributes'] = ['ID' => $index + 1];

            foreach ($addresses as $key => $value) {

                if (in_array($key, $this->allowedProperties)) {

                    $this->addresses[$index][$key] = $value;
                }
            }
        }
    }

    protected function convertAddressesToXML()
    {
        return ArrayToXml::convert( ['Address' => $this->addresses],
            [
                'rootElementName' => 'AddressValidateRequest',

                '_attributes' => ['USERID' => config('services.usps.userId')]

            ], false
        );
    }

    public function validate()
    {
        $addressXML = urlencode($this->convertAddressesToXML());

        $client = new Client(['base_uri' => 'https://secure.shippingapis.com/', 'verify' => config('services.usps.verifySsl')]);

        $response =  $client->request('GET', "ShippingAPI.dll?API=Verify&XML=$addressXML");

        return $response->getBody();
    }
}
