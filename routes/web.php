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
    return view('layouts.app');
});

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::group([
    'name' => 'doctors',
    'prefix' => 'doctors',
    'middleware' =>['role:super-admin|admin|pharmacy', 'auth'],
], function () {
    Route::get('/', 'DoctorController@index')->name('doctors.index');
    Route::get('/create', 'DoctorController@create')->name('doctors.create');
    Route::get('/{doctor}', 'DoctorController@show')->name('doctors.show');
    Route::post('/', 'DoctorController@store')->name('doctors.store');
    Route::delete('/{doctor}', 'DoctorController@destroy')->name('doctors.destroy');
});
Route::get('/doctors/{doctor}/edit', 'DoctorController@edit')->name('doctors.edit')->middleware(['role_or_permission:super-admin|admin|pharmacy|update doctor', 'auth']);
Route::put('/doctors/{doctor}', 'DoctorController@update')->name('doctors.update')->middleware(['role_or_permission:super-admin|admin|pharmacy|update doctor', 'auth']);
Route::post('/doctors/updateajax/{doctor}', 'DoctorController@updateajax')->name('doctors.updateajax')->middleware(['role_or_permission:super-admin|admin|pharmacy|update doctor', 'auth']);

Route::group([
    'name' => 'clients',
    'prefix' => 'clients',
    'middleware' =>['role:super-admin|admin', 'auth'],

], function () {
    Route::get('/', 'ClientController@index')->name('clients.index');
    Route::get('/create', 'ClientController@create')->name('clients.create');
    Route::get('/{client}', 'ClientController@show')->name('clients.show');
    Route::post('/', 'ClientController@store')->name('clients.store');
    Route::delete('/{client}', 'ClientController@destroy')->name('clients.destroy');
});
Route::get('/clients/{client}/edit', 'ClientController@edit')->name('clients.edit')->middleware(['role_or_permission:super-admin|admin', 'auth']);
Route::put('/clients/{client}', 'ClientController@update')->name('clients.update')->middleware(['role_or_permission:super-admin|admin', 'auth']);


Route::group([
    'name' => 'areas',
    'prefix' => 'areas',
    'middleware' => ['role:super-admin|admin'],

], function () {
    Route::get('/', 'AreaController@index')->name('areas.index');
    Route::get('/create', 'AreaController@create')->name('areas.create');
    Route::get('/{area}', 'AreaController@show')->name('areas.show');
    Route::get('/{area}/edit', 'AreaController@edit')->name('areas.edit');
    Route::put('/{area}', 'AreaController@update')->name('areas.update');
    Route::post('/', 'AreaController@store')->name('areas.store');
    Route::delete('/{area}', 'AreaController@destroy')->name('areas.destroy');
});

Route::group([
    'name' => 'useraddresses',
    'prefix' => 'useraddresses',
    'middleware' => ['role:super-admin|admin|client|doctor|pharmacy'],
], function () {
    Route::get('/', 'UserAddressController@index')->name('useraddresses.index');
    Route::get('/create', 'UserAddressController@create')->name('useraddresses.create');
    Route::get('/{useraddress}', 'UserAddressController@show')->name('useraddresses.show');
    Route::get('/{useraddress}/edit', 'UserAddressController@edit')->name('useraddresses.edit');
    Route::put('/{useraddress}', 'UserAddressController@update')->name('useraddresses.update');
    Route::post('/', 'UserAddressController@store')->name('useraddresses.store');
    Route::post('/user', 'UserAddressController@user')->name('useraddresses.user');
    Route::delete('/{useraddress}', 'UserAddressController@destroy')->name('useraddresses.destroy');
});


Route::group([
    'name' => 'pharmacies',
    'prefix' => 'pharmacies',
    'middleware' => ['role:super-admin|admin', 'auth'],
], function () {
    Route::get('/', 'PharmacyController@index')->name('pharmacies.index');
    Route::get('/create', 'PharmacyController@create')->name('pharmacies.create');
    Route::post('/', 'PharmacyController@store')->name('pharmacies.store');
    Route::delete('/{pharmacy}', 'PharmacyController@destroy')->name('pharmacies.destroy');

    Route::get('/{pharmacy}/softdelete', 'PharmacyController@softdelete')->name('pharmacies.softdelete');
    Route::get('/readsoftdelete', 'PharmacyController@readsoftdelete')->name('pharmacies.readsoftdelete');
    Route::get('{pharmacy}/restore', 'PharmacyController@restore')->name('pharmacies.restore');
    Route::get('/{pharmacy}', 'PharmacyController@show')->name('pharmacies.show');
});
Route::put(
    '/pharmacies/{pharmacy}',
    'PharmacyController@update'
)->name('pharmacies.update')->middleware(['auth']);
Route::get(
    '/pharmacies/{pharmacy}/edit',
    'PharmacyController@edit'
)->name('pharmacies.edit')->middleware(['role_or_permission:super-admin|admin|update pharmacy', 'auth']);

Route::group([
    'name' => 'orders',
    'prefix' => 'orders',
    'middleware' => ['role_or_permission:super-admin|admin|doctor|pharmacy', 'auth'],
], function () {
    Route::delete('/{order}', 'OrderController@destroy')->name('orders.destroy');
    Route::get('/', 'OrderController@index')->name('orders.index');
    Route::get('/create', 'OrderController@create')->name('orders.create');
    Route::post('/', 'OrderController@store')->name('orders.store');
    Route::get('{order}', 'OrderController@show')->name('orders.show');
    Route::get('{order}/edit', 'OrderController@edit')->name('orders.edit');
    Route::put('/', 'OrderController@update')->name('orders.update');
    
});

// Route::resource('orders', 'OrderController');


Route::group([
    'name' => 'medicines',
    'prefix' => 'medicines',
    'middleware' => ['role:super-admin|admin|doctor|pharmacy', 'auth'],
], function () {
    Route::get('/get-medicines', 'MedicineController@getMedicines')->name('get-medicines-datatable');
    Route::delete('/{medicine}/delete', 'MedicineController@destroy')->name('medicines.destroy');
    Route::get('/', 'MedicineController@index')->name('medicines.index');
    //    Route::get('/create', 'MedicineController@create')->name('medicines.create');
    Route::post('/store', 'MedicineController@store')->name('medicines.store');
    Route::get('/{medicine}/edit', 'MedicineController@edit')->name('medicines.edit');
    Route::get('/{medicine}', 'MedicineController@show')->name('medicines.show');
    Route::post('/{medicine}/update', 'MedicineController@update')->name('medicines.update');
});

Auth::routes(['verify' => true , 'register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('stripe/{order}', 'OrderController@pay')->middleware('auth');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post')->middleware('auth');


Route::get('/revenue', 'RevenueController@index')->name('revenue.index')->middleware(['role:super-admin|admin','auth']);
Route::get('ajaxdata/getAllData', 'RevenueController@getalldata')->name('ajaxdata.getAllData');

Route::get('/revenue1', 'RevenueControllerForPharmacy@index')->name('revenueForPharmacy.index')->middleware(['role:pharmacy','auth']);
Route::get('ajaxdata/getdata', 'RevenueControllerForPharmacy@getdata')->name('ajaxdata.getdata');

// ordermedicine
Route::group(
    [
        'middleware' => ['role:super-admin|admin|doctor|pharmacy', 'auth'],
    ],
    function () {
        Route::post('/medicineorder', 'MedicineOrderController@store')->name('medicineorder.store');
        Route::post('/medicineauto', 'MedicineController@auto')->name('medicine.auto');
        Route::post('/medicineorder/{order}', 'MedicineOrderController@update')->name('medicine.update');
    }
);