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
    	Route::delete('/', 'StoresController@destroy')->name('Stores.delete');



   });

});
