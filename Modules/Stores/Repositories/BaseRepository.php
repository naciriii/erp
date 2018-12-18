<?php

namespace Modules\Stores\Repositories;

use Modules\Stores\Entities\Store;
//use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Session;
use Cookie;
use Crypt;
use Cache;


 class BaseRepository
{
    protected $store;
    protected $client;
    protected $api_token;
    protected $token;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->api_token = config('stores.api_token');
    }

    public function setStore(Store $store)
    {
        $this->store = $store;
        if ($this->token == null) {
            $token = $this->getAuthToken();
            $this->token = "Bearer " . $token;
        }
    }

    public function getStore(): Store
    {
        return $this->store;
    }

    public function getAuthToken()
    {
        $store_id = $this->store->id . '_access_token';
        if (Cookie::get($store_id) != null) {
            return Crypt::decrypt(Cookie::get($store_id));
        } else {

            $login = $this->store->api_login;
            $pass = decrypt($this->store->api_password);

            $url = config('stores.api.base_url') . config('stores.api.auth_url');
            $response = $this->client->request('POST', $url, [
                'headers' => [
                    "Content-Type" => "application/json",
                    "api-token" => $this->api_token
                ],
                'json' => [
                    'login' => $login,
                    'password' => $pass,
                    'api_url' => $this->store->api_url
                ]
            ]);
            $result = json_decode(trim($response->getBody()->getContents()));
            if (isset($result->status) && $result->status == "Unauthorized Magento") {
                return abort(404, "Api Credentials Mismatch!");
            }
            Cookie::queue($store_id, $result, 15);
            return $result;
        }
    }

    protected function getDataFromApi($method, $uri, $bodyParams = null)
    {
        $body = [
            'headers' => [
                'Accept' => 'application/json',
                'token' => $this->token,
                "api-token" => $this->api_token
            ]
        ];
        if ($bodyParams != null) {
            $body['json'] = $bodyParams;
        }
        $response = $this->client->request($method, $uri, $body);


        $data = $response->getBody()->getContents();

        return json_decode($data);
    }
}