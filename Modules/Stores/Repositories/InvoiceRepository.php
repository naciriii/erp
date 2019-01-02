<?php

namespace Modules\Stores\Repositories;


use Modules\Stores\Repositories\Contracts\BaseRepository as BaseRepositoryI;
use Cache;

class InvoiceRepository extends BaseRepository implements BaseRepositoryI
{
    public function all($params = null)
    {
        $invoices = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.invoices_url'), [
            'api_url' => $this->store->api_url,
            'page_size' => $params['page_size'],
            'current_page' => $params['current_page']
        ]);
        return $invoices;
    }

    public function find($orderId)
    {
        $data = $this->getDataFromApi('POST',
            config('stores.api.base_url') .
            str_replace('{orderId}', $orderId, config('stores.api.get_invoice_url')), [
            'api_url' => $this->store->api_url]);
        return $data;
    }

    public function add($params)
    {
        $order = $this->getDataFromApi(
            'POST',
            config('stores.api.base_url') . config('stores.api.add_invoice_url'), [
            'api_url' => $this->store->api_url,
            'order_id' => $params['order_id'],
            'entity_id' => $params['entity_id']
        ]);
        return $order;
    }

    public function update($order, $orderId)
    {
        return "update";
    }

    public function delete($orderId)
    {
        return "delete";
    }
}