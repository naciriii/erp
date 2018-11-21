<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;


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

}