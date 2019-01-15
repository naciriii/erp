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
        return "add";
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