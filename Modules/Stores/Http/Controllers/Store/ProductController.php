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
			'result' => $result
		];
		
		return view('stores::store.products.index')->with($data);
		
	}

}