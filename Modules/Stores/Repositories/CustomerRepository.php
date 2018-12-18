<?php

namespace Modules\Stores\Repositories;


use Modules\Stores\Repositories\Contracts\BaseRepository as BaseRepositoryI;
use Cache;

class CustomerRepository extends BaseRepository implements BaseRepositoryI
{

    /**
     * Display a listing of Customers.
     * @return Response
     */
//[$page_size, $current_page]
    public function all($params = null)
    {
        $customers = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.customers_url'), [
            'api_url' => $this->store->api_url,
            'page_size' => $params['page_size'],
            'current_page' => $params['current_page']
        ]);
        return $customers;
    }

    public function find($customerId)
    {
        $customer = $this->getDataFromApi('POST',
            config('stores.api.base_url') . str_replace('{customerId}',
                $customerId, config('stores.api.get_customer_url')), [
                'api_url' => $this->store->api_url]);
        return $customer;
    }

    public function getCustomerBy($field, $value)
    {
        $customers = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.customers_filter_url'), [
            'api_url' => $this->store->api_url,
            'field' => $field,
            'value' => $value
        ]);
        return $customers;
    }

    public function add($customer)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.add_customer_url'), [
            'api_url' => $this->store->api_url,
            'customer' => json_encode($customer)
        ]);
        return $result;
    }

    public function update($customer, $customerId)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{customerId}', $customerId,
                config('stores.api.update_customer_url')), [
            'api_url' => $this->store->api_url,
            'customer' => json_encode($customer)
        ]);
        Cache::forget('customers');
        return $result;
    }

    public function delete($customerId)
    {
        $customer = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{customerId}', $customerId,
                config('stores.api.delete_customer_url')), [
            'api_url' => $this->store->api_url]);
        Cache::forget('customers');
        return $customer;
    }

}