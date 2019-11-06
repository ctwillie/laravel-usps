<?php

namespace ctwillie\Usps;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Spatie\ArrayToXml\ArrayToXml;
use GuzzleHttp\Client;

abstract class API {

    const PROD_URL = 'https://secure.shippingapis.com/ShippingAPI.dll';
    const LOCAL_URL = 'http://production.shippingapis.com/ShippingAPITest.dll';
    protected $env = 'local';
    protected $apiUrl = self::LOCAL_URL;
    protected $userId;
    
    public function __construct() {
        $this->setEnvironment();
        $this->setApiUrl();
        $this->userId = config('services.usps.userid');
    }

    // Determines the current application environment
    public function setEnvironment()
    {
        // config settings take precedence
        if (Config::has('services.usps.env')) {
            $this->env = strtolower(config('services.usps.env'));
        // next check .env
        } elseif (App::environment(['local', 'development'])) {
            $this->env = 'local';
        } elseif (App::environment(['production'])) {
            $this->env = 'production';
        }
        // defaults to local
    }

    public function setApiUrl()
    {
        $this->apiUrl = $this->env === 'local' ? self::LOCAL_URL : self::PROD_URL;
    }

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

    public function validate()
    {
        return $this->makeRequest();
    }

    abstract public function getRequestData() : array;

    public function makeRequest()
    {

        $xml = $this->convertToXML();
        
        $client = new Client(['base_uri' => $this->apiUrl, 'verify' => config('services.usps.verifyssl')]);

        $response =  $client->request('GET', "ShippingAPI.dll?API=$this->apiType&XML=$xml");

        return $response->getBody();
    }

}