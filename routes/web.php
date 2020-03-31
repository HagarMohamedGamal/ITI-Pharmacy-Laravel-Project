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


Route::get('/pharmacies', 'PharmacyController@index')->name('pharmacies.index');

// =======================create========================
Route::get('/pharmacies/create', 'PharmacyController@create')->name('pharmacies.create');

Route::post('/pharmacies', 'PharmacyController@store')->name('pharmacies.store');


// ========================update=========================
Route::get('/pharmacies/{pharmacy}/edit', 'PharmacyController@edit')->name('pharmacies.edit');

Route::put('/pharmacies/{pharmacy}', 'PharmacyController@update')->name('pharmacies.update');


Route::get('/pharmacies/{pharmacy}', 'PharmacyController@show')->name('pharmacies.show');

// ========================destroy=========================
Route::delete('/pharmacies/{pharmacy}', function () {
    // return view('pharmacy.destroy');
})->name('pharmacies.destroy');



