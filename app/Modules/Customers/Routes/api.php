<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/get-all-customers', 'CustomersController@getAllCustomers');
Route::post('/add-new-customer', 'CustomersController@createNewCustomer');
Route::post('/update-customer/{id}', 'CustomersController@updateCustomer');
Route::post('/delete-customer/{id}', 'CustomersController@deleteCustomer');
