<?php

namespace ctwillie\Usps;

class Address extends API
{
    // use map to determine root element
    // key will be api type ('verify' => 'AddressValidateRequest')
    protected $rootElementName = 'AddressValidateRequest';
    protected $apiType = 'Verify';
    protected $addresses = [];
    protected $allowedProperties = ['Address1','Address2','City','State','Zip4','Zip5'];
    protected $addressTemplate = ['_attributes' => [],'Address1' => '','Address2' => '','City' => '','State' => '','Zip5' => '','Zip4' => ''];

    /**
     * Handles single or multiple addresses passes to constructor
     * 
     * @param array $addresses
     * @return void
     * 
     */
    public function __construct(array $addresses = [])
    {
        parent::__construct();
        array_key_exists(0, $addresses) ? $this->handleMultipleAddresses($addresses) : $this->handleSingleAddress($addresses);
    }

    /**
     * Handles multiple addresses 
     * 
     * @param array $addresses
     * @return void
     * 
     */
    public function handleMultipleAddresses(array $addresses)
    {
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
    }

    /**
     * Handles single address 
     * 
     * @param array $address
     * @return void
     * 
     * Add addAddress method which calls this method and checks five address limit
     * 
     */
    public function handleSingleAddress(array $address)
    {
        $index = 0;
        // Set to address template
        $this->addresses[$index] = $this->addressTemplate;
        // reset address fields
        $this->addresses[$index]['_attributes'] = ['ID' => $index + 1];

        foreach ($address as $key => $value) {

            if (in_array($key, $this->allowedProperties)) {

                $this->addresses[$index][$key] = $value;
            }
        }
    }

    public function getRequestData() : array
    {
        return ['Address' => $this->addresses];
    }
}
