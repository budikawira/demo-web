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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/sendmoney', 'PaymentController@sendMoney');
Route::post('/api/cellular', 'PaymentController@cellular');
Route::post('/api/pln', 'PaymentController@pln');
Route::post('/api/withdraw', 'PaymentController@withdraw');
Route::post('/api/topup1', 'PaymentController@topUpManual1');
Route::post('/api/price', 'PaymentController@price');
Route::post('/api/payment', 'PaymentController@payment');
Route::post('/api/invoice', 'PaymentController@invoice');
Route::get('/api/invoice/{amount}/{bankName}/{bankAccount}/{expired}/{message}', 'PaymentController@getInvoice');