<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::group([
    'name'=>'areas',
    'prefix'=>'areas',
],function(){
    Route::get('/index','AreaController@index');
    Route::get('/create', 'AreaController@create');
    Route::get('/{area}','AreaController@show');
    Route::get('/{area}/edit', 'AreaController@edit');
    Route::put('/{area}','AreaController@update');
    Route::post('/','AreaController@store');
    Route::delete('/{area}', 'AreaController@destroy');
});

Route::group([
    'name' => 'useraddresses',
    'prefix' => 'useraddresses',
], function () {
    Route::get('/index', 'UserAddressController@index');
    Route::get('/create', 'UserAddressController@create');
    Route::get('/{useraddress}', 'UserAddressController@show');
    Route::get('/{useraddress}/edit', 'UserAddressController@edit');
    Route::put('/{useraddress}', 'UserAddressController@update');
    Route::post('/', 'UserAddressController@store');
    Route::delete('/{useraddress}', 'UserAddressController@destroy');
});


Route::group([
    'name' => 'pharmacies',
    'prefix' => 'pharmacies',
], function () {
    Route::get('/', 'PharmacyController@index')->name('pharmacies.index');
    Route::get('/create', 'PharmacyController@create')->name('pharmacies.create');
    Route::get('/{pharmacy}', 'PharmacyController@show')->name('pharmacies.show');
    Route::get('/{pharmacy}/edit', 'PharmacyController@edit')->name('pharmacies.edit');
    Route::put('/{pharmacy}', 'PharmacyController@update')->name('pharmacies.update');
    Route::post('/', 'PharmacyController@store')->name('pharmacies.store');
    Route::delete('/{pharmacy}', 'PharmacyController@destroy')->name('pharmacies.destroy');
    Route::get('/{pharmacy}/softdelete', 'PharmacyController@softdelete')->name('pharmacies.softdelete');
    Route::get('/readsoftdelete', 'PharmacyController@readsoftdelete')->name('pharmacies.readsoftdelete');
    Route::get('{pharmacy}/restore', 'PharmacyController@restore')->name('pharmacies.restore');
});


Route::group([
    'name' => 'orders',
    'prefix' => 'orders',
], function () {
    Route::delete('/{order}', 'OrderController@destroy')->name('orders.destroy');
    Route::get('/', 'OrderController@index')->name('orders.index');
    Route::get('/create', 'OrderController@create')->name('orders.create');
    Route::post('/', 'OrderController@store')->name('orders.store');
    Route::get('{order}', 'OrderController@show')->name('orders.show');
    Route::get('{order}/edit', 'OrderController@edit')->name('orders.edit');
    Route::put('{order}', 'OrderController@update')->name('orders.update');
    
});