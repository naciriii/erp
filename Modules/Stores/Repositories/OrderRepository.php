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

    public function add($order)
    {
        return "add";
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

    public function delete($orderId)
    {
        return "delete";
    }
}