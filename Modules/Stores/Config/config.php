<?php

return [
    'name' => 'Stores',
    'api_token' => 'nao3ieptlkrjW1RiSaAuS5C1sU6D0IXG',
    'api' => [
    	'base_url' =>env('base_url','http://mgukn.test/'),
    	'auth_url' => 'api/auth',
    	'categories_url' => 'api/categories',
    	'products_url' => 'api/products',
    	'get_product_url' => 'api/products/{sku}',
    	'add_product_url' => 'api/products/store',
    	'update_product_url' => 'api/products/update/{sku}',
    	'delete_product_url' => 'api/products/delete/{sku}',

    ]
];
