<?php

namespace ctwillie\Usps;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Spatie\ArrayToXml\ArrayToXml;
use GuzzleHttp\Client;

abstract class API {

    const PROD_URL = 'https://secure.shippingapis.com/ShippingAPI.dll';
    const LOCAL_URL = 'http://production.shippingapis.com/ShippingAPITest.dll';
    protected $env;
    protected $apiUrl;
    protected $userId;
    
    public function __construct() {
        $this->setEnvironment();
        $this->setUrl();
        $this->userId = config('services.usps.userid');
    }

    // Determines the current application environment
    public function setEnvironment()
    {
        if (Config::has('services.usps.env')) {
            $this->env = strtolower(config('services.usps.env'));
        } elseif (App::environment(['local', 'development'])) {
            $this->env = 'local';
        } 
        $this->env = 'production';
    }

    public function setUrl()
    {
        $this->apiUrl = $this->env === 'local' ? self::LOCAL_URL : self::PROD_URL;
    }

    public function checkForUserId()
    {
        if (is_null($this->userId)) {
            throw new \Exception('USPS: A user ID is required. None found in config/services.php');
        }
    }

    // create a map to determine the rootElementName foreach api type
    protected function convertToXML()
    {
        $xml = ArrayToXml::convert( $this->getRequestData(),
            [
                'rootElementName' => $this->rootElementName,

                '_attributes' => ['USERID' => $this->userId]

            ], false
        );
        return urlencode($xml);
    }

    public function makeRequest()
    {
        $this->checkForUserId();

        $xml = $this->convertToXML();
        
        $client = new Client(['base_uri' => $this->apiUrl, 'verify' => config('services.usps.verifyssl', true)]);

        $response =  $client->request('GET', "?API=$this->apiType&XML=$xml");

        return $response->getBody();
    }

    // Abstract to be defined by each entity
    abstract public function getRequestData() : array;

    public function validate()
    {
        return $this->makeRequest();
    }

}