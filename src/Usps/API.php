<?php

namespace ctwillie\Usps;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Spatie\ArrayToXml\ArrayToXml;
use GuzzleHttp\Client;

/**
 * Class used by each entity to interact with the API and get configurations
 * 
 * Each entity will be responsible for managing its own data used in the api
 * request. This class handles the common functions, such as, data formatting,
 * creating http client, making request, returning response etc.
 * 
 */
abstract class API {

    const PROD_URL = 'https://secure.shippingapis.com/ShippingAPI.dll';
    const LOCAL_URL = 'http://production.shippingapis.com/ShippingAPITest.dll';
    protected $env;
    protected $apiUrl;
    protected $userId;
    protected $rootElements = [
        'Verify' => 'AddressValidateRequest'
    ];
    
    /** Determines env to set api url, http client settings etc. */
    public function __construct() {
        $this->setEnvironment();
        $this->setUrl();
        $this->userId = config('services.usps.userid');
    }

    /** Determines the current application env */
    public function setEnvironment()
    {
        if (Config::has('services.usps.env')) {

            $this->env = strtolower(config('services.usps.env'));

        } elseif (App::environment(['local', 'development'])) {

            $this->env = 'local';
        }

        $this->env = 'production';
    }

    /** Determines the api url to use based on running env */
    public function setUrl()
    {
        $this->apiUrl = $this->env === 'local' ? self::LOCAL_URL : self::PROD_URL;
    }

    /**
     * Makes sure a userid has been provided
     * 
     * @throws Exception If no userid is found in config/services.php
     */
    public function checkForUserId()
    {
        if (is_null($this->userId)) {
            throw new \Exception('USPS: A user ID is required. None found in config/services.php');
        }
    }

    /**
     * Converts entity data into xml format and url encodes
     * 
     * @return string
     */
    protected function convertToXML()
    {
        $xml = ArrayToXml::convert( $this->getRequestData(),
            [
                'rootElementName' => $this->rootElements[$this->apiType],

                '_attributes' => ['USERID' => $this->userId]

            ], false
        );
        return urlencode($xml);
    }

    /**
     * Handles making the api request
     * 
     * This method handles creating the http client and gathering
     * all necessary data for making the api request.
     * 
     * @return StreamInterface of the response content body
     */
    public function makeRequest()
    {
        $this->checkForUserId();

        $xml = $this->convertToXML();
        
        $client = new Client(['base_uri' => $this->apiUrl, 'verify' => config('services.usps.verifyssl', true)]);

        $response =  $client->request('GET', "?API=$this->apiType&XML=$xml");

        return $response->getBody();
    }

    /**
     * Each entity decides the array structure for the request data
     * 
     * @return array
     */
    abstract public function getRequestData();

    public function validate()
    {
        return $this->makeRequest();
    }

}