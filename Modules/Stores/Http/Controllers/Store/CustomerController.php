<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;


class CustomerController extends StoreController
{

	

	public function index()
	{
			$result  = $this->repository->getAllCustomers();
		
	
		$data = [
			'store' => $this->getStore(),
			'result' => $result
		];		

		return view('stores::store.customers.index')->with($data);
		
	}
	
	/*
	public function show($id,$sku)
	{
		$result = $this->repository->getCustomer($sku);
		if($result == null) {
			return abort(404);
		}
		$categories = $this->repository->getAllCategories();
		$data = [
			'customer' => $result,
			'categories' => $categories,
			'store' => $this->getStore()];
		return view('stores::store.customers.show')->with($data);


	}
	public function create($id)
	{
		
		$categories = $this->repository->getAllCategories();
		$data = ['categories' => $categories,'store' => $this->getStore()];
		return view('stores::store.customers.create')->with($data);

	}
	public function store($id,Request $request)
	{
		$this->validate($request, [
			'sku' => 'required',
			'name' => 'required',
			'price' => 'required|numeric',
			'quantity' => 'required|numeric',
			'category.*' => 'integer']);

		$customerObj = $this->getCustomerModel();
		//dd($request->all(),$customerObj->customer);
		$customerObj->customer->sku = $request->sku ;
		$customerObj->customer->name = $request->name;
		$customerObj->customer->price = $request->price;
		$customerObj->customer->extensionAttributes->stockItem->qty = $request->quantity;
		$categories = new \StdClass;
		
		$categories->attribute_code = "category_ids";
		$categories->value = $request->category;

		

		$customerObj->customer->customAttributes [] = $categories;
		
		$customer = $this->repository->addCustomer($customerObj);
		
		return redirect()->route('Store.Customers.index',['id' =>$id])->with(['response' => 
                            [
             trans('stores::global.Customer_added'),
             trans('stores::global.Customer_added_success',['customer' => '<b>'.$request->name.'</b>']),
                'info'
            ]]);





	}
	public function update($id,$sku,Request $request)
	{
		$this->validate($request, [
			'sku' => 'required',
			'name' => 'required',
			'price' => 'required|numeric',
			'quantity' => 'required|numeric',
			'category.*' => 'integer']);

		$customerObj = $this->getCustomerModel();
		//dd($request->all(),$customerObj->customer);
		$customerObj->customer->sku = $request->sku ;
		$customerObj->customer->name = $request->name;
		$customerObj->customer->price = $request->price;
		$customerObj->customer->extensionAttributes->stockItem->qty = $request->quantity;
		$categories = new \StdClass;
		
		$categories->attribute_code = "category_ids";
		$categories->value = $request->category;

		

		$customerObj->customer->customAttributes [] = $categories;
		
		$customer = $this->repository->updateCustomer($sku,$customerObj);
		
		return redirect()->route('Store.Customers.index',['id' =>$id])->with(['response' => 
                            [
             trans('stores::global.Customer_updated'),
             trans('stores::global.Customer_updated_success',['customer' => '<b>'.$request->name.'</b>']),
                'info'
            ]]);


	}
	public function delete($id,$sku)
	{
	$result = $this->repository->deleteCustomer($sku);

	$data = [
			'result' => $result,
			'store' => $this->getStore()
		];
		return redirect()->route('Store.Customers.index',['id' =>$id])->with(['response' => 
                            [
             trans('stores::global.Customer_deleted'),
             trans('stores::global.Customer_deleted_success',['customer' => '<b>'.$sku.'</b>']),
                'info'
            ]]);

		return view('stores::store.customers.index')->with($data);
	}



	private function getCustomerModel() {

		$prod = json_decode('{
  "customer": {
    "sku": "MY_SKU1",
    "name": "My Customer1",
    "attributeSetId": "4",
    "price": 20,
    "status": 1,
    "visibility": 4,
    "typeId": "simple",
    "weight": 0,
    "extensionAttributes": {
      "stockItem": {
        "stockId": 1,
        "qty": 20,
        "isInStock": true,
        "isQtyDecimal": false,
        "useConfigMinQty": true,
        "minQty": 0,
        "useConfigMinSaleQty": 0,
        "minSaleQty": 0,
        "useConfigMaxSaleQty": true,
        "maxSaleQty": 0,
        "useConfigBackorders": false,
        "backorders": 0,
        "useConfigNotifyStockQty": true,
        "notifyStockQty": 20,
        "useConfigQtyIncrements": false,
        "qtyIncrements": 0,
        "useConfigEnableQtyInc": false,
        "enableQtyIncrements": false,
        "useConfigManageStock": true,
        "manageStock": true,
        "lowStockDate": "string",
        "isDecimalDivided": true,
        "stockStatusChangedAuto": 0,
        "extensionAttributes": {}
      }
    },
    "options": [],
    "tierPrices": [],
    "customAttributes": [
    ]
  },
  "saveOptions": true
}');
	return $prod;
}*/

}