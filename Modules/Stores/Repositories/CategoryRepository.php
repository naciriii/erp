<?php

namespace Modules\Stores\Repositories;


use Modules\Stores\Repositories\Contracts\BaseRepository as BaseRepositoryI;
use Cache;

class CategoryRepository extends BaseRepository implements BaseRepositoryI
{

    public function all($params = null)
    {
        $categories = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.categories_url'), [
            'api_url' => $this->store->api_url
        ]);
        if (isset($categories->children_data)) {
            return collect($categories->children_data);
        }
        return collect([]);
    }

    public function find($cat)
    {

        $category = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{cat}', $cat, config('stores.api.get_category_url')), [
            'api_url' => $this->store->api_url]);
        return $category;
    }

    public function add($category)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.add_category_url'), [
            'api_url' => $this->store->api_url,
            'category' => json_encode($category)
        ]);

        return $result;
    }

    public function update($category, $cat)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url')
            . str_replace('{cat}', $cat, config('stores.api.update_category_url')), [
            'api_url' => $this->store->api_url,
            'category' => json_encode($category)
        ]);
        return $result;
    }

    public function delete($cat)
    {
        $category = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{cat}',
                $cat, config('stores.api.delete_category_url')), [
            'api_url' => $this->store->api_url]);
        Cache::forget('categories');
        return $category;
    }





}