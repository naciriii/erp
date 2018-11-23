<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;


class ProductController extends StoreController
{

	

	public function index()
	{
		
		$result  = $this->repository->getAllProducts();
		$result->items = collect($result->items);
		$data = [
			'result' => $result,
			'store' => $this->getStore()
		];

		return view('stores::store.products.index')->with($data);
		
	}
	public function show($id,$sku)
	{
		$result = $this->repository->getProduct($sku);
		$categories = $this->repository->getAllCategories();
		$data = ['product' => $result,'categories' => $categories];
		return view('stores::store.products.show')->with($data);


	}
	public function create($id)
	{
		
		$categories = $this->repository->getAllCategories();
		$data = ['categories' => $categories,'store' => $this->getStore()];
		return view('stores::store.products.create')->with($data);

	}
	public function store($id,Request $request)
	{

		$productObj = $this->getProductModel();
		//dd($request->all(),$productObj->product);
		$productObj->product->sku = $request->sku ;
		$productObj->product->name = $request->name;
		$productObj->product->price = $request->price;
		$productObj->product->extensionAttributes->stockItem->qty = $request->quantity;
		$categories = new \StdClass;
		
		$categories->attribute_code = "category_ids";
		$categories->value = $request->category;

		

		$productObj->product->customAttributes [] = $categories;
		
		$product = $this->repository->addProduct($productObj);
		dd($product);





	}



	private function getProductModel() {

		$prod = json_decode('{
  "product": {
    "sku": "MY_SKU1",
    "name": "My Product1",
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
}

}