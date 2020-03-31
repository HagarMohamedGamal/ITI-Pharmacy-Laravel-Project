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



