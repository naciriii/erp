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
Route::prefix('users')->middleware('auth')->group(function() {
    Route::get('/', 'UsersController@index')->name('Users.index');
    Route::get('/create','UsersController@create')->name('Users.create');
    Route::post('/create', 'UsersController@store')->name('Users.store');
    Route::get('/{id}','UsersController@show')->name('Users.show');
    Route::patch('/{id}','UsersController@update')->name('Users.update');
    Route::delete('/{id}','UsersController@destroy')->name('Users.delete');
});
