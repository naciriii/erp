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


		 $categories = $this->getDataFromApi('POST',config('stores.api.base_url').config('stores.api.categories_url'),[
       
        'api_url' => $this->store->api_url
       
    ]);

		return collect($categories->children_data);

	}

    public function getAllProducts()
    {

         $products = $this->getDataFromApi('POST',config('stores.api.base_url').config('stores.api.products_url'),[
       
        'api_url' => $this->store->api_url
       
    ]);

        return $products;

    }
    public function getProduct($sku)
    {
        $product = $this->getDataFromApi('POST',config('stores.api.base_url').str_replace('{sku}', $sku, config('stores.api.get_product_url')), [
            'api_url' => $this->store->api_url]);
        return $product;
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
        $store_id = $this->store->id.'_access_token';
        if(Session::has($store_id)) {
            return session($store_id);
        } else {
            
    	$login = $this->store->api_login;
    	$pass = decrypt($this->store->api_password);
       
    $url = config('stores.api.base_url').config('stores.api.auth_url');
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
        session([$store_id => json_decode(trim($response->getBody()->getContents()))]);

    	return session($store_id);
    }
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