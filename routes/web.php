<?php

use App\Doctor;
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

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::group([
    'name' => 'doctors',
    'prefix' => 'doctors',
    'middleware' => 'auth',
], function () {
    Route::get('/', 'DoctorController@index')->name('doctors.index');
    Route::get('/{doctor}/edit', 'DoctorController@edit')->name('doctors.edit');
    Route::put('/{doctor}', 'DoctorController@update')->name('doctors.update');
    Route::get('/create', 'DoctorController@create')->name('doctors.create');
    Route::get('/{doctor}', 'DoctorController@show')->name('doctors.show');
    Route::post('/', 'DoctorController@store')->name('doctors.store');
    Route::delete('/{doctor}', 'DoctorController@destroy')->name('doctors.destroy');
    
});

Route::group([
    'name'=>'areas',
    'prefix'=>'areas',
],function(){
    Route::get('/index','AreaController@index')->name('areas.index');
    Route::get('/create', 'AreaController@create')->name('areas.create');
    Route::get('/{area}','AreaController@show')->name('areas.show');
    Route::get('/{area}/edit', 'AreaController@edit')->name('areas.edit');
    Route::put('/{area}','AreaController@update')->name('areas.update');
    Route::post('/','AreaController@store')->name('areas.store');
    Route::delete('/{area}', 'AreaController@destroy')->name('areas.destroy');
});

Route::group([
    'name' => 'useraddresses',
    'prefix' => 'useraddresses',
], function () {
    Route::get('/index', 'UserAddressController@index')->name('useraddresses.index');
    Route::get('/create', 'UserAddressController@create')->name('useraddresses.create');
    Route::get('/{useraddress}', 'UserAddressController@show')->name('useraddresses.show');
    Route::get('/{useraddress}/edit', 'UserAddressController@edit')->name('useraddresses.edit');
    Route::put('/{useraddress}', 'UserAddressController@update')->name('useraddresses.update');
    Route::post('/', 'UserAddressController@store')->name('useraddresses.store');
    Route::delete('/{useraddress}', 'UserAddressController@destroy')->name('useraddresses.destroy');
});


Route::group([
    'name' => 'pharmacies',
    'prefix' => 'pharmacies',
    'middleware' => ['auth', 'verified'],
], function () {
    Route::get('/', 'PharmacyController@index')->name('pharmacies.index');
    Route::get('/create', 'PharmacyController@create')->name('pharmacies.create');
    Route::get('/{pharmacy}/edit', 'PharmacyController@edit')->name('pharmacies.edit');
    Route::put('/{pharmacy}', 'PharmacyController@update')->name('pharmacies.update');
    Route::post('/', 'PharmacyController@store')->name('pharmacies.store');
    Route::delete('/{pharmacy}', 'PharmacyController@destroy')->name('pharmacies.destroy');
    Route::get('/{pharmacy}/softdelete', 'PharmacyController@softdelete')->name('pharmacies.softdelete');
    Route::get('/readsoftdelete', 'PharmacyController@readsoftdelete')->name('pharmacies.readsoftdelete');
    Route::get('{pharmacy}/restore', 'PharmacyController@restore')->name('pharmacies.restore');
    Route::get('/{pharmacy}', 'PharmacyController@show')->name('pharmacies.show');
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

Route::group([
    'name' => 'medicines',
    'prefix' => 'medicines',
], function () {
    Route::delete('/{medicine}', 'MedicineController@destroy')->name('medicines.destroy');
    Route::get('/', 'MedicineController@index')->name('medicines.index');
    Route::get('/create', 'MedicineController@create')->name('medicines.create');
    Route::post('/', 'MedicineController@store')->name('medicines.store');
    Route::get('/{medicine}/edit', 'MedicineController@edit')->name('medicines.edit');
    Route::get('/{medicine}', 'MedicineController@show')->name('medicines.show');
    Route::put('/{medicine}', 'MedicineController@update')->name('medicines.update');
});
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
