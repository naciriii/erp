<?php

namespace Modules\Stores\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Stores\Entities\Store;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Session;

class StoreRepository 
{
	protected $store;
	private $client;

	public function __construct(Client $client)
	{
		$this->client = $client;

	}

	public function setStore(Store $store)
	{
		$this->store = $store;
		Session::put("authorize","Bearer ".$this->getAuthToken());
		//$this->getAllCategories();

	}
	public function getAllCategories()
	{
		 $categories = $this->getDataFromApi('GET',config('stores.api.categories_url'));
		return collect($categories->children_data);


	}







	 private function getAuthToken()
    {

    	$login = $this->store->api_login;
    	$pass = decrypt($this->store->api_password);

    $url = $this->store->api_url.config('stores.api.auth_url');
  

    	$response = $this->client->request('POST', $url, [
    		 'headers' => [
    		 	"Content-Type"=>"application/json"
    ],
    'json' => [
        'username' => $login,
        'password' => $pass
       
    ]
]);
    	return json_decode(trim($response->getBody()->getContents()));

    }

    private function getDataFromApi($method, $uri)
    {


        	$response = $this->client->request($method, $this->store->api_url.$uri, 
        		
        		 [
    'headers' => [
        'Accept'     => 'application/json',
        'Authorization'      => session('authorize')
    ]
]);

        	$data = $response->getBody()->getContents();

        return json_decode($data);


    }
}