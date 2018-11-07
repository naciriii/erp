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
Route::prefix('users')->group(function() {
    Route::get('/', 'UsersController@index')->name('Users.index');
    Route::get('/{id}','UsersController@show')->name('Users.show');
    Route::patch('/{id}','UsersController@update')->name('Users.update');
});
