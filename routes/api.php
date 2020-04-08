<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('clients/login', 'API\ClientController@login');
Route::post('/clients/register', 'API\ClientController@register');
Route::get('/clients', 'API\ClientController@index')->middleware(['auth:sanctum','APIverified']);
Route::put('/clients/{client}', 'API\ClientController@update')->middleware(['auth:sanctum','verified']);
Route::delete('/clients/{client}', 'API\ClientController@destroy')->middleware(['auth:sanctum','verified']);
Route::get('/clients/{client}', 'API\ClientController@show')->middleware(['auth:sanctum','verified']);



Route::get('email/verifyLink/{id}', 'API\VerificationApiController@verifyLink')->name('verificationapi.verifyLink');
Route::get('email/verify/{id}', 'API\VerificationApiController@verify')->name('verificationapi.verify');
Route::get('email/resend/{id}', 'API\VerificationApiController@resend')->name('verificationapi.resend');





    




