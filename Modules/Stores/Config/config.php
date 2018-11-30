<?php

return [
    'name' => 'Stores',
    'api_token' => '325bfe991e4d273',
    'api' => [
    	'base_url' =>env('base_url','http://mgukn.test/'),
    	'auth_url' => 'api/auth',
    	'categories_url' => 'api/categories',
        'add_category_url' => 'api/categories/store',
    	'products_url' => 'api/products',
    	'get_product_url' => 'api/products/{sku}',
    	'add_product_url' => 'api/products/store',
    	'update_product_url' => 'api/products/update/{sku}',
    	'delete_product_url' => 'api/products/delete/{sku}',
        'customers_url' => 'api/customers',

    ]
];
