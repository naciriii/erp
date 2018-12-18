<?php

return [
    'name' => 'Stores',
    'api_token' => env('INTEGRATION_TOKEN','nao3ieptlkrjW1RiSaAuS5C1sU6D0IXG'),
    'api' => [
        'public_resources'=>'/pub/media/catalog/product',
    	'base_url' =>env('base_url','http://mgukn.test/'),
    	'auth_url' => 'api/auth',
    	'categories_url' => 'api/categories',
        'get_category_url' => 'api/categories/{cat}',
        'update_category_url' => 'api/categories/update/{cat}',
        'delete_category_url' => 'api/categories/delete/{cat}',
        'add_category_url' => 'api/categories/store',

    	'products_url' => 'api/products',
    	'get_product_url' => 'api/products/{sku}',
    	'add_product_url' => 'api/products/store',
    	'update_product_url' => 'api/products/update/{sku}',
    	'delete_product_url' => 'api/products/delete/{sku}',

        'add_product_media_url' => 'api/products/add/media/{sku}',
        'update_product_media_url' => 'api/products/update/media/{sku}',

        'customers_url' => 'api/customers',
        'delete_customer_url' => 'api/customers/delete/{customerId}',
        'get_customer_url' => 'api/customers/{customerId}',
        'update_customer_url' => 'api/customers/update/{customerId}',
        'add_customer_url' => 'api/customers/store',
        'customers_filter_url'=>'api/customers/findby'
    ]
];
