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

Route::prefix('stores')->group(function() {
    Route::get('/', 'StoresController@index')->name('Stores.index');
    Route::get('/create', 'StoresController@create')->name('Stores.create');
    Route::post('/store', 'StoresController@store')->name('Stores.store');
    Route::prefix('/{id}')->group(function() {
    	Route::get('/', 'StoresController@show')->name('Stores.show');
    	Route::patch('/', 'StoresController@update')->name('Stores.update');
    	Route::delete('/', 'StoresController@destroy')->name('Stores.delete');




   });


});

Route::prefix('store/{id}')->group(function() {
	Route::get('/','StoreController@index')->name('Store.index');
    Route::get('/products','Store\ProductController@index')->name('Store.Products.index');
    Route::get('/products/{sku}','Store\ProductController@show')->name('Store.Products.show');

	});
