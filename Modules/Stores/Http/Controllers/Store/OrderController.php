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
            'findBy' => ''
        ];

        return view('stores::store.orders.index')->with($data);
    }

    public function create($id)
    {
        $data = [
            'store' => $this->getStore()
        ];
        // TODO: create an order
        return view('stores::store.orders.create')->with($data);
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



    public function updateStatus($id,Request $request)
    {
        if($request->status == 1){
            $status = 'cancel';
        }elseif($request->status == 2){
            $status  = 'hold';
        }elseif($request->status == 3){
            $status = 'unhold';
        }else{
            return redirect()->back();
        }

        $statusObj =json_decode('{
            "entity": {
                "entity_id": 0,
                "state":"",
                "status": ""
            }
        }');

        $statusObj->entity->entity_id = $request->entity_id;
        $statusObj->entity->state = $status;
        $statusObj->entity->status = $status;

        $this->repository->updateStatus($statusObj);

        return redirect()->route('Store.Orders.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Order_status_updated'),
                trans('stores::global.Order_updated_success', ['order' => '<b>' . $request->order_id . '</b>']),
                'info'
            ]]);
    }

}
