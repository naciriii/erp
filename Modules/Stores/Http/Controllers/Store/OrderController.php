<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;


class OrderController extends StoreController
{
    public function index()
    {
        $current_page = $this->page;
        $result = $this->repository->all(['page_size' => 20, 'current_page' => $current_page]);
        //dd($result);
        $data = [
            'store' => $this->getStore(),
            'result' => $result,
            'findBy'=>''
        ];

        return view('stores::store.orders.index')->with($data);
    }

    public function create()
    {
        // TODO: create an order
        return view('stores::store.create.index');
    }

    public function store(Request $request)
    {
        // TODO: store an order
        return 'create order';
    }

    public function search(Request $request)
    {
        // TODO: search an order
        $data = [
            'store' => $this->getStore()
        ];
        return view('stores::store.orders.index')->with($data);
    }

    public function show($id)
    {
        // TODO: show order details
        return view('stores::store.show.index');
    }

    public function update()
    {
        // TODO: update order
        return "update order";
    }
}
