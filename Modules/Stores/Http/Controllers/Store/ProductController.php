<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends StoreController
{


    public function index()
    {
        $current_page = $this->page;
        $result = $this->repository->all(['page_size' => 20, 'current_page' => $current_page]);

        foreach ($result->items as $item) {
            if (count(collect($item->custom_attributes)->where('attribute_code', 'special_from_date'))) {
                $from = new Carbon(collect($item->custom_attributes)->where('attribute_code', 'special_from_date')->first()->value);
                collect($item->custom_attributes)->where('attribute_code', 'special_from_date')->first()->value = $from->format('Y-m-d');
            }

            if (count(collect($item->custom_attributes)->where('attribute_code', 'special_to_date'))) {
                $to = new Carbon(collect($item->custom_attributes)->where('attribute_code', 'special_to_date')->first()->value);
                collect($item->custom_attributes)->where('attribute_code', 'special_to_date')->first()->value = $to->format('Y-m-d');
            }
        }

        $data = [
            'result' => $result,
            'store' => $this->getStore(),
            'findBy'=>''
        ];
        return view('stores::store.products.index')->with($data);
    }

    public function show($id, $sku)
    {
        $result = $this->repository->find($sku);
        if ($result == null) {
            return abort(404);
        }
        if (count(collect($result->custom_attributes)->where('attribute_code', 'special_to_date'))) {
            $from = new Carbon(collect($result->custom_attributes)->where('attribute_code', 'special_from_date')->first()->value);
            collect($result->custom_attributes)->where('attribute_code', 'special_from_date')->first()->value = $from->format('Y-m-d');

            $to = new Carbon(collect($result->custom_attributes)->where('attribute_code', 'special_to_date')->first()->value);
            collect($result->custom_attributes)->where('attribute_code', 'special_to_date')->first()->value = $to->format('Y-m-d');
        }

        $categories = $this->repository->categories();
        $data = [
            'product' => $result,
            'categories' => $categories,
            'store' => $this->getStore()
        ];
        return view('stores::store.products.show')->with($data);
    }

    public function create($id)
    {
        $categories = $this->repository->categories();
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
            'category.*' => 'integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $productObj = $this->getProductModel();
        $productObj->product->sku = $request->sku;
        $productObj->product->name = $request->name;
        $productObj->product->price = $request->price;
        $productObj->product->extensionAttributes->stockItem->qty = $request->quantity;

        $categories = new \StdClass;

        $categories->attribute_code = "category_ids";
        $categories->value = $request->category;
        $productObj->product->customAttributes [] = $categories;

        if ($request->special_price) {

            $this->validate($request, [
                'special_price' => 'required | numeric',
                'special_from_date' => 'required | date',
                'special_to_date' => 'required | date'
            ]);

            $specialPrice = new \StdClass;
            $specialPrice->attribute_code = "special_price";
            $specialPrice->value = $request->special_price;
            $productObj->product->customAttributes [] = $specialPrice;

            $specialFromDate = new \StdClass;
            $specialFromDate->attribute_code = "special_from_date";
            $specialFromDate->value = $request->special_from_date;
            $productObj->product->customAttributes [] = $specialFromDate;

            $specialToDate = new \StdClass;
            $specialToDate->attribute_code = "special_to_date";
            $specialToDate->value = $request->special_to_date;
            $productObj->product->customAttributes [] = $specialToDate;
        }

        $product = $this->repository->add($productObj);

        if ($product) {
            $media = $this->getProductMedia();
            $media->entry->mediaType = 'image';
            $media->entry->label = $request->sku;
            $media->entry->file = $request->sku;
            $media->entry->content->base64_encoded_data = base64_encode(file_get_contents($request->file('image')));
            $media->entry->content->type = $request->image->getClientMimeType();
            $media->entry->content->name = time() . '.' . $request->image->getClientOriginalExtension();
            $this->repository->addProductMedia($media, $request->sku);
        }

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
            'category.*' => 'integer'
        ]);

        $productObj = $this->getProductModel();

        $productObj->product->sku = $request->sku;
        $productObj->product->name = $request->name;
        $productObj->product->price = $request->price;
        $productObj->product->extensionAttributes->stockItem->qty = $request->quantity;

        $categories = new \StdClass;
        $categories->attribute_code = "category_ids";
        $categories->value = $request->category;
        $productObj->product->customAttributes [] = $categories;

        if ($request->special_price) {

            $this->validate($request, [
                'special_price' => 'required | numeric',
                'special_from_date' => 'required | date',
                'special_to_date' => 'required | date'
            ]);

            $specialPrice = new \StdClass;
            $specialPrice->attribute_code = "special_price";
            $specialPrice->value = $request->special_price;
            $productObj->product->customAttributes [] = $specialPrice;

            $specialFromDate = new \StdClass;
            $specialFromDate->attribute_code = "special_from_date";
            $specialFromDate->value = $request->special_from_date;
            $productObj->product->customAttributes [] = $specialFromDate;

            $specialToDate = new \StdClass;
            $specialToDate->attribute_code = "special_to_date";
            $specialToDate->value = $request->special_to_date;
            $productObj->product->customAttributes [] = $specialToDate;
        } else {
            $specialPrice = new \StdClass;
            $specialPrice->attribute_code = "special_price";
            $specialPrice->value = null;
            $productObj->product->customAttributes [] = $specialPrice;

            $specialFromDate = new \StdClass;
            $specialFromDate->attribute_code = "special_from_date";
            $specialFromDate->value = null;
            $productObj->product->customAttributes [] = $specialFromDate;

            $specialToDate = new \StdClass;
            $specialToDate->attribute_code = "special_to_date";
            $specialToDate->value = null;
            $productObj->product->customAttributes [] = $specialToDate;
        }


        $product = $this->repository->update($sku, $productObj);
        if ($request->hasFile('image')) {

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $media = $this->getProductMedia();
            $media->entry->mediaType = 'image';
            $media->entry->label = $request->sku;
            $media->entry->file = $request->sku;
            $media->entry->content->base64_encoded_data = base64_encode(file_get_contents($request->file('image')));
            $media->entry->content->type = $request->image->getClientMimeType();
            $media->entry->content->name = time() . '.' . $request->image->getClientOriginalExtension();

            if ($request->media_id) {
                $media->entry->id = $request->media_id;
                $this->repository->updateProductMedia($media, $request->sku, $request->media_id);
            } else {
                $this->repository->addProductMedia($media, $request->sku);
            }
        }

        return redirect()->route('Store.Products.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Product_updated'),
                trans('stores::global.Product_updated_success', ['product' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);
    }

    public function delete($id, $sku)
    {
        $result = $this->repository->delete($sku);

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

    public function findProductBy($id, Request $request)
    {
        $current_page = $this->page;
        $params = [
            'page_size' => 20,
            'current_page' => $current_page
        ];

        $result = $this->repository->getProductBy('name', $request->search, $params);

        foreach ($result->items as $item) {
            if (count(collect($item->custom_attributes)->where('attribute_code', 'special_from_date'))) {
                $from = new Carbon(collect($item->custom_attributes)->where('attribute_code', 'special_from_date')->first()->value);
                collect($item->custom_attributes)->where('attribute_code', 'special_from_date')->first()->value = $from->format('Y-m-d');
            }

            if (count(collect($item->custom_attributes)->where('attribute_code', 'special_to_date'))) {
                $to = new Carbon(collect($item->custom_attributes)->where('attribute_code', 'special_to_date')->first()->value);
                collect($item->custom_attributes)->where('attribute_code', 'special_to_date')->first()->value = $to->format('Y-m-d');
            }
        }

        $data = [
            'result' => $result,
            'store' => $this->getStore(),
            'findBy' => $request->search
        ];

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
                              "customAttributes": []
                            },
                            "saveOptions": true
                          }');
        return $prod;
    }

    private function getProductMedia()
    {
        $media = json_decode('{
                    "entry": {
                        "id": 0,
                        "mediaType": "image",
                        "label": "string",
                        "position": 0,
                        "disabled": "false",
                        "extension_attributes": {
                            "video_content": []
                        },
                        "types": [
                            "image",
                            "thumbnail",
                            "small_image"
                        ],
                        "file": "string",
                        "content": {
                            "base64_encoded_data": "string",
                            "type": "image/jpeg",
                            "name": "string.jpg"
                        }
                    }
                }');

        return $media;
    }

}