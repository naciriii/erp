<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;


class CategoryController extends StoreController
{
    private $categories = [];

    private function extract($result)
    {
        foreach ($result as $c) {
            $this->categories[] = $c;
            if (count($c->children_data)) {
                $this->extract($c->children_data);
            }
        }
    }

    public function index()
    {
        $this->extract($this->repository->getAllCategories());
        $data = [
            'result' => collect($this->categories),
            'store' => $this->getStore()
        ];
//        dd($data);
        return view('stores::store.categories.index')->with($data);
    }

    public function create($id)
    {
        $categories = $this->repository->getAllCategories();
        $data = [
            'categories' => $categories,
            'store' => $this->getStore()
        ];
        return view('stores::store.categories.create', $data);
    }

    public function store($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'is_active' => 'required'
        ]);
        //dd($request->input());
        $categoryObj = $this->getCategoryModel();
        $categoryObj->category->name = $request->name;
        $categoryObj->category->isActive = ($request->is_active == 0) ? false : true;
        $categoryObj->category->parentId = ($request->parent_id) ? $request->parent_id : 0;

        $this->repository->addCategory($categoryObj);

        return redirect()->route('Store.Categories.index', ['id' => $id])
            ->with(['response' => [
                trans('stores::global.Category_added'),
                trans('stores::global.Category_added_success', ['category' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);
    }

    private function getCategoryModel()
    {
        $category = json_decode(
            '{
            "category": {
                "id": 0,
                "parentId": 0,
                "name": "category 1",
                "isActive": true,
                "position": 0,
                "level": 0,
                "includeInMenu": true,
                "extensionAttributes": {},
                "customAttributes": []
            }
          }'
        );
        return $category;
    }

}