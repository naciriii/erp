<?php

namespace Modules\Stores\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Stores\Entities\Store;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Session;
use Cookie;

class StoreRepository 
{
	protected $store;
	private $client;
    private $api_token;
    private $token;

	public function __construct(Client $client)
	{
		$this->client = $client;
        $this->api_token = config('stores.api_token');

	}

	public function getAllCategories()
	{


		 $categories = $this->getDataFromApi('POST',config('stores.api.categories_url'),[
       
        'api_url' => $this->store->api_url
       
    ]);

		return collect($categories->children_data);

	}

    public function getAllProducts()
    {

         $products = $this->getDataFromApi('POST',config('stores.api.products_url'),[
       
        'api_url' => $this->store->api_url
       
    ]);

        return $products;

    }






    public function setStore(Store $store)
    {
        $this->store = $store;
        if($this->token == null) {
        $token = "Bearer ".$this->getAuthToken();

        $this->token = $token;
    }

    }
    public function getStore():Store
    {
        return $this->store;
    }
	 private function getAuthToken()
    {

    	$login = $this->store->api_login;
    	$pass = decrypt($this->store->api_password);
       
    $url = config('stores.api.auth_url');
      	$response = $this->client->request('POST', $url, [
    		 'headers' => [
    		 	"Content-Type"=>"application/json",
                "api-token" => $this->api_token
    ],
    'json' => [
        'login' => $login,
        'password' => $pass,
        'api_url' => $this->store->api_url
    ]
    ]);
    	return json_decode(trim($response->getBody()->getContents()));
    }
    private function getDataFromApi($method, $uri, $bodyParams = null)
    {
        $body =          [
    'headers' => [
        'Accept'     => 'application/json',
        'token'      => $this->token,
        "api-token" => $this->api_token
    ]
    ];
        if($bodyParams != null) {
          $body['json'] = $bodyParams;
            }
            
    $response = $this->client->request($method, $uri, $body);

        	$data = $response->getBody()->getContents();

        return json_decode($data);
    }
}