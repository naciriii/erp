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

Route::prefix('authorization')->group(function() {
	Route::prefix('roles')->group(function() {
		Route::get('/', 'RoleController@index')->name('Roles.index');
		Route::get('/create', 'RoleController@create')->name('Roles.create');
		Route::post('/create', 'RoleController@store')->name('Roles.store');
		Route::get('/{id}', 'RoleController@show')->name('Roles.show');
		Route::patch('/{id}', 'RoleController@update')->name('Roles.update');
		Route::delete('/{id}', 'RoleController@destroy')->name('Roles.destroy');

	});
	Route::prefix('permissions')->group(function() {
		Route::get('/', 'PermissionController@index')->name('Permissions.index');
		Route::get('/create', 'PermissionController@create')->name('Permissions.create');
		Route::post('/create', 'PermissionController@store')->name('Permissions.store');
		Route::get('/{id}', 'PermissionController@show')->name('Permissions.show');
		Route::patch('/{id}', 'PermissionController@update')->name('Permissions.update');
		Route::delete('/{id}', 'PermissionController@destroy')->name('Permissions.destroy');

	});
    
   
});
