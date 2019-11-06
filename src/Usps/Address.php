<?php

namespace ctwillie\Usps;

/**
 * This class gathers data for the 'Verify' api route
 * 
 * It is responsible for formatting address request data that
 * will be handled by the API class
 */
class Address extends API
{
    protected $apiType = 'Verify';
    protected $addresses = [];
    protected $allowedProperties = ['Address1','Address2','City','State','Zip4','Zip5'];
    protected $addressTemplate = ['_attributes' => [],'Address1' => '','Address2' => '','City' => '','State' => '','Zip5' => '','Zip4' => ''];

    /**
     * Handles single or multiple addresses passes to constructor
     * 
     * @param array $addresses
     */
    public function __construct(array $addresses = [])
    {
        parent::__construct();
        array_key_exists(0, $addresses) ? $this->handleMultipleAddresses($addresses) : $this->handleSingleAddress($addresses);
    }

    /**
     * Handles adding multiple addresses 
     * 
     * @param array $addresses
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
     * Handles adding a single address
     * 
     * @param array $address
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

    /**
     * Formats the request data.
     * 
     * @return array
     */
    public function getRequestData()
    {
        return ['Address' => $this->addresses];
    }
}
