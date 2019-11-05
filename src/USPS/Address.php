<?php

namespace ctwillie\Usps;

class Address extends API
{
    // use map to determine root element
    // key will be api type ('verify' => 'AddressValidateRequest')
    protected $rootElementName = 'AddressValidateRequest';
    protected $apiType = 'Verify';
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
        parent::__construct();

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

    public function getRequestData()
    {
        return ['Address' => $this->addresses];
    }
}
