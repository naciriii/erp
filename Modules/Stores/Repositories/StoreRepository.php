<?php

namespace Modules\Stores\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Stores\Entities\Store;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Session;
use Cookie;
use Crypt;
use Cache;

class StoreRepository implements BaseRepository
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
        $categories = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.categories_url'), [
            'api_url' => $this->store->api_url
        ]);
        if (isset($categories->children_data)) {
            return collect($categories->children_data);
        }
        return collect([]);
    }

    public function getCategory($cat)
    {

        $category = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{cat}', $cat, config('stores.api.get_category_url')), [
            'api_url' => $this->store->api_url]);
        return $category;
    }

    public function addCategory($category)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.add_category_url'), [
            'api_url' => $this->store->api_url,
            'category' => json_encode($category)
        ]);

        return $result;
    }

    public function updateCategory($category, $cat)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url')
            . str_replace('{cat}', $cat, config('stores.api.update_category_url')), [
            'api_url' => $this->store->api_url,
            'category' => json_encode($category)
        ]);
        return $result;
    }

    public function deleteCategory($cat)
    {
        $category = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{cat}',
                $cat, config('stores.api.delete_category_url')), [
            'api_url' => $this->store->api_url]);
        Cache::forget('categories');
        return $category;
    }

    public function getAllProducts()
    {
        $products = Cache::remember('products', 5, function () {
            return $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.products_url'), [
                'api_url' => $this->store->api_url
            ]);
        });
        return $products;
    }

    public function getProduct($sku)
    {
        $product = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{sku}', $sku, config('stores.api.get_product_url')), [
            'api_url' => $this->store->api_url]);
        return $product;
    }

    public function addProduct($product)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.add_product_url'), [
            'api_url' => $this->store->api_url,
            'product' => json_encode($product)
        ]);
        Cache::forget('products');
        return $result;
    }

    public function updateProduct($sku, $product)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{sku}', $sku, config('stores.api.update_product_url')), [
            'api_url' => $this->store->api_url,
            'product' => json_encode($product)
        ]);
        Cache::forget('products');
        return $result;
    }

    public function deleteProduct($sku)
    {
        $product = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{sku}', $sku, config('stores.api.delete_product_url')), [
            'api_url' => $this->store->api_url]);
        Cache::forget('products');
        return $product;
    }


    /**
     * Display a listing of Customers.
     * @return Response
     */

    public function getAllCustomers($page_size, $current_page)
    {
        $customers = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.customers_url'), [

            'api_url' => $this->store->api_url,
            'page_size' => $page_size,
            'current_page' => $current_page

        ]);

        return $customers;

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

    private function getDataFromApi($method, $uri, $bodyParams = null)
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