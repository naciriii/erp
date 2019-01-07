<?php

namespace Modules\Stores\Repositories;


use Modules\Stores\Repositories\Contracts\BaseRepository as BaseRepositoryI;
use Cache;

class OrderRepository extends BaseRepository implements BaseRepositoryI
{
    public function all($params = null)
    {
        $orders = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.orders_url'), [
            'api_url' => $this->store->api_url,
            'page_size' => $params['page_size'],
            'current_page' => $params['current_page']
        ]);
        return $orders;
    }

    public function find($orderId)
    {
        return "find";
    }

    public function add($orderObj)
    {
        $order = $this->getDataFromApi(
            'POST',
            config('stores.api.base_url') . config('stores.api.add_new_orders_url'), [
            'api_url' => $this->store->api_url,
            'entity' => json_encode($orderObj)
        ]);

        return $order;
    }

    public function update($order, $orderId)
    {
        return "update";
    }

    public function updateStatus($statusObj)
    {
        $order = $this->getDataFromApi(
            'POST',
            config('stores.api.base_url') . config('stores.api.orders_update_status_url'), [
            'api_url' => $this->store->api_url,
            'entity' => json_encode($statusObj)
        ]);
        return $order;
    }

    public function getCustomers($params)
    {
        $customers = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.customers_url'), [
            'api_url' => $this->store->api_url,
            'page_size' => $params['page_size'],
            'current_page' => $params['current_page']
        ]);
        return $customers;
    }

    public function getCustomer($customerId)
    {
        $customer = $this->getDataFromApi('POST',
            config('stores.api.base_url') . str_replace('{customerId}',
                $customerId, config('stores.api.get_customer_url')), [
                'api_url' => $this->store->api_url]);
        return $customer;
    }

    public function getProducts($params)
    {
        $products = $this->getDataFromApi('POST', config('stores.api.base_url') .
            config('stores.api.products_url'), [
            'api_url' => $this->store->api_url,
            'page_size' => $params['page_size'],
            'current_page' => $params['current_page']
        ]);
        return $products;
    }

    public function createCarts($customerId)
    {
        $cartId = $this->getDataFromApi('POST',
            config('stores.api.base_url') . config('stores.api.post_order_customer_cart_url'), [
                'api_url' => $this->store->api_url,
                'customerId' => $customerId
            ]);
        return $cartId;
    }

    public function addBillingAddressToCart($params)
    {
        $billingAddress = $this->getDataFromApi('POST',
            config('stores.api.base_url') . config('stores.api.post_billing_address_to_cart'), [
                'api_url' => $this->store->api_url,
                'cartId' => $params['cartId'],
                'billingAddress' => json_encode($params['billingAddress'])
            ]);
        return $billingAddress;
    }

    public function delete($orderId)
    {
        return "delete";
    }
}