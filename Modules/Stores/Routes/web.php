<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('stores')->group(function () {
    Route::get('/', 'StoresController@index')->name('Stores.index');
    Route::get('/create', 'StoresController@create')->name('Stores.create');
    Route::post('/store', 'StoresController@store')->name('Stores.store');
    Route::prefix('/{id}')->group(function () {
        Route::get('/', 'StoresController@show')->name('Stores.show');
        Route::patch('/', 'StoresController@update')->name('Stores.update');
        Route::delete('/', 'StoresController@destroy')->name('Stores.delete');


    });


});


Route::prefix('store/{id}')->group(function () {
    Route::get('/', 'StoreController@index')->name('Store.index');

    Route::prefix('/products')->group(function () {
        Route::get('/', 'Store\ProductController@index')->name('Store.Products.index');
        Route::get('/create', 'Store\ProductController@create')->name('Store.Products.create');
        Route::get('/{sku}', 'Store\ProductController@show')->name('Store.Products.show');
        Route::post('/', 'Store\ProductController@store')->name('Store.Products.store');
        Route::put('{sku}', 'Store\ProductController@update')->name('Store.Products.update');
        Route::delete('/{sku}', 'Store\ProductController@delete')->name('Store.Products.destroy');
    });

    Route::prefix('/customers')->group(function () {
        Route::get('/', 'Store\CustomerController@index')->name('Store.Customers.index');
        Route::post('/getcustomers', 'Store\CustomerController@getCustomers')->name('Store.Customers.getCustomers');
    });

    Route::prefix('/categories')->group(function () {
        Route::get('/', 'Store\CategoryController@index')->name('Store.Categories.index');
        Route::get('/create', 'Store\CategoryController@create')->name('Store.Categories.create');
        Route::post('/store', 'Store\CategoryController@store')->name('Store.Categories.store');

        Route::get('/{cat}', 'Store\CategoryController@show')->name('Store.Categories.show');

        Route::put('/{cat}', 'Store\CategoryController@update')->name('Store.Categories.update');
        Route::delete('/{cat}', 'Store\CategoryController@delete')->name('Store.Categories.destroy');


    });


});
