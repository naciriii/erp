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
    Route::get('/products', 'Store\ProductController@index')->name('Store.Products.index');
    Route::get('/products/create', 'Store\ProductController@create')->name('Store.Products.create');
    Route::get('/products/{sku}', 'Store\ProductController@show')->name('Store.Products.show');

    Route::post('/products', 'Store\ProductController@store')->name('Store.Products.store');
    Route::put('/products/{sku}', 'Store\ProductController@update')->name('Store.Products.update');
    Route::delete('/products/{sku}', 'Store\ProductController@delete')->name('Store.Products.destroy');

    Route::get('/categories', 'Store\CategoryController@index')->name('Store.Categories.index');
    Route::get('/categories/create', 'Store\CategoryController@create')->name('Store.Categories.create');

    Route::post('/categories', 'Store\CategoryController@store')->name('Store.Categories.store');


});
