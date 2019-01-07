<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;


class InvoiceController extends StoreController
{
    public function index()
    {
        $current_page = $this->page;
        $result = $this->repository->all(['page_size' => 20, 'current_page' => $current_page]);

        $data = [
            'store' => $this->getStore(),
            'result' => $result,
            'findBy' => ''
        ];

        return view('stores::store.invoices.index')->with($data);
    }

    public function show($id, $entityId)
    {
        $result = $this->repository->find(decode($entityId));

        if ($result == null) {
            return abort(404);
        }

        $data = [
            'order' => $result->order,
            'invoice' => $result->invoice,
            'store' => $this->getStore()
        ];
        return view('stores::store.invoices.show')->with($data);
    }
}