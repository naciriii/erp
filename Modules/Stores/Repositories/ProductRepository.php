<?php

namespace Modules\Stores\Repositories;


use Modules\Stores\Repositories\Contracts\BaseRepository as BaseRepositoryI;
use Cache;

class ProductRepository extends BaseRepository implements BaseRepositoryI
{


    public function all($params = null)
    {
        $products = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.products_url'), [
            'api_url' => $this->store->api_url,
            'page_size' => $params['page_size'],
            'current_page' => $params['current_page']
        ]);

        return $products;
    }

    public function categories($params = null)
    {
        $categories = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.categories_url'), [
            'api_url' => $this->store->api_url
        ]);
        if (isset($categories->children_data)) {
            return collect($categories->children_data);
        }
        return collect([]);
    }

    public function find($sku)
    {
        $product = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{sku}', $sku, config('stores.api.get_product_url')), [
            'api_url' => $this->store->api_url]);
        return $product;
    }

    public function add($product)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url') . config('stores.api.add_product_url'), [
            'api_url' => $this->store->api_url,
            'product' => json_encode($product)
        ]);
        Cache::forget('products');
        return $result;
    }

    public function update($sku, $product)
    {
        $result = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{sku}', $sku, config('stores.api.update_product_url')), [
            'api_url' => $this->store->api_url,
            'product' => json_encode($product)
        ]);
        Cache::forget('products');
        return $result;
    }

    public function delete($sku)
    {
        $product = $this->getDataFromApi('POST', config('stores.api.base_url') . str_replace('{sku}', $sku, config('stores.api.delete_product_url')), [
            'api_url' => $this->store->api_url]);
        Cache::forget('products');
        return $product;
    }

    public function addProductMedia($media, $sku)
    {
        $media = $this->getDataFromApi('POST',
            config('stores.api.base_url') . str_replace('{sku}', $sku, config('stores.api.add_product_media_url')), [
                'api_url' => $this->store->api_url,
                'entry' => json_encode($media)
            ]);
        Cache::forget('products');
        return $media;
    }

    public function updateProductMedia($media, $sku, $mediaId)
    {
        $media = $this->getDataFromApi('POST',
            config('stores.api.base_url') . str_replace('{sku}', $sku, config('stores.api.update_product_media_url')), [
                'api_url' => $this->store->api_url,
                'entry' => json_encode($media),
                'mediaId' => $mediaId
            ]);
        Cache::forget('products');
        return $media;
    }






}