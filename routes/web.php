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
    return view('home');
});

Auth::routes();

// PROMOMATERIAAL

Route::get('/promomateriaal', 'PromoMateriaalController@index');
Route::get('/promomateriaal/get', 'PromoMateriaalController@getPromoItemsInStock');

// BEURSMATERIAAL

Route::get('/beursmateriaal', 'BeursMateriaalController@index');
Route::get('/beursmateriaal/get', 'BeursMateriaalController@getBeursItems');

// KANTOORMATERIAAL

Route::get('/kantoormateriaal', 'KantoorMateriaalController@index');
Route::get('/kantoormateriaal/get', 'KantoorMateriaalController@getKantoorItemsInStock');

// ORDERS

Route::post('/promomateriaal/order/create', 'PromoOrderController@store');
Route::post('/kantoormateriaal/order/create', 'KantoorOrderController@store');
Route::post('/beursmateriaal/order/create', 'BeursOrderController@store');

// USERDATA

Route::get('/userdata', function(){
	return Auth::user();
});
