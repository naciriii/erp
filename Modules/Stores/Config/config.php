<?php

return [
    'name' => 'Stores',
    'api_token' => env('INTEGRATION_TOKEN','nao3ieptlkrjW1RiSaAuS5C1sU6D0IXG'),
    'google_token' => 'AIzaSyDRHqQl5jVDSwvGp1d569VAbeHA8PIhEF8',
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
        'products_search_url'=>'api/products/search',

        'customers_url' => 'api/customers',
        'delete_customer_url' => 'api/customers/delete/{customerId}',
        'get_customer_url' => 'api/customers/{customerId}',
        'update_customer_url' => 'api/customers/update/{customerId}',
        'add_customer_url' => 'api/customers/store',
        'customers_filter_url'=>'api/customers/findby',


        'orders_url' => 'api/orders',
        'delete_order_url' => 'api/orders/delete/{orderId}',
        'get_order_url' => 'api/orders/{orderId}',
        'update_order_url' => 'api/orders/update/{orderId}',
        'add_order_url' => 'api/orders/store',

        'customers_search_url'=>'api/customers/search',

        'orders_url' => 'api/orders',
        'add_new_orders_url' => 'api/orders/store',
        'orders_update_status_url' => 'api/orders/update/status',

        'invoices_url' => 'api/invoices',
        'get_invoice_url' => 'api/invoices/{orderId}',
        'add_invoice_url' => 'api/create/invoices',

        'post_order_customer_cart_url' => 'api/orders/customers/cart',
        'post_billing_address_to_cart' => 'api/orders/cart/address'

    ]
];
