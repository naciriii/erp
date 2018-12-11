<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;


class ProductController extends StoreController
{


    public function index()
    {
        $result = $this->repository->getAllProducts();
        $data = [
            'result' => $result,
            'store' => $this->getStore()
        ];
        return view('stores::store.products.index')->with($data);
    }

    public function show($id, $sku)
    {
        $result = $this->repository->getProduct($sku);
        if ($result == null) {
            return abort(404);
        }
        $categories = $this->repository->getAllCategories();
        $data = [
            'product' => $result,
            'categories' => $categories,
            'store' => $this->getStore()
        ];
        return view('stores::store.products.show')->with($data);
    }

    public function create($id)
    {
        $categories = $this->repository->getAllCategories();
        $data = ['categories' => $categories, 'store' => $this->getStore()];
        return view('stores::store.products.create')->with($data);
    }

    public function store($id, Request $request)
    {
        $this->validate($request, [
            'sku' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category.*' => 'integer']);

        $productObj = $this->getProductModel();
        //dd($request->all(),$productObj->product);
        $productObj->product->sku = $request->sku;
        $productObj->product->name = $request->name;
        $productObj->product->price = $request->price;
        $productObj->product->extensionAttributes->stockItem->qty = $request->quantity;
        $categories = new \StdClass;

        $categories->attribute_code = "category_ids";
        $categories->value = $request->category;

        $productObj->product->customAttributes [] = $categories;

        $product = $this->repository->addProduct($productObj);

        return redirect()->route('Store.Products.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Product_added'),
                trans('stores::global.Product_added_success', ['product' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);


    }

    public function update($id, $sku, Request $request)
    {
        $this->validate($request, [
            'sku' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category.*' => 'integer']);

        $productObj = $this->getProductModel();
        //dd($request->all(),$productObj->product);
        $productObj->product->sku = $request->sku;
        $productObj->product->name = $request->name;
        $productObj->product->price = $request->price;
        $productObj->product->extensionAttributes->stockItem->qty = $request->quantity;
        $categories = new \StdClass;

        $categories->attribute_code = "category_ids";
        $categories->value = $request->category;


        $productObj->product->customAttributes [] = $categories;

        $product = $this->repository->updateProduct($sku, $productObj);

        return redirect()->route('Store.Products.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Product_updated'),
                trans('stores::global.Product_updated_success', ['product' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);


    }

    public function delete($id, $sku)
    {
        $result = $this->repository->deleteProduct($sku);

        $data = [
            'result' => $result,
            'store' => $this->getStore()
        ];
        return redirect()->route('Store.Products.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Product_deleted'),
                trans('stores::global.Product_deleted_success', ['product' => '<b>' . $sku . '</b>']),
                'info'
            ]]);

        return view('stores::store.products.index')->with($data);
    }


    private function getProductModel()
    {

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