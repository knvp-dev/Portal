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

Route::get('/promomateriaal/orders', 'PromoOrderController@index');
Route::get('/kantoormateriaal/orders', 'KantoorOrderController@index');
Route::get('/beursmateriaal/orders', 'BeursOrderController@index');

Route::get('/promomateriaal/orders/{status}', 'PromoOrderController@getByStatus');
Route::get('/kantoormateriaal/orders/{status}', 'KantoorOrderController@getByStatus');
Route::get('/beursmateriaal/orders/{status}', 'BeursOrderController@getByStatus');

Route::post('/promomateriaal/order/create', 'PromoOrderController@store');
Route::post('/kantoormateriaal/order/create', 'KantoorOrderController@store');
Route::post('/beursmateriaal/order/create', 'BeursOrderController@store');

Route::get('/promomateriaal/detail/{id}', 'PromoOrderController@show');
Route::get('/kantoormateriaal/detail/{id}', 'KantoorOrderController@show');
Route::get('/beursmateriaal/detail/{id}', 'BeursOrderController@show');

Route::get('/promomateriaal/order/detail/{id}', 'PromoOrderController@getOrderDetail');
Route::get('/kantoormateriaal/order/detail/{id}', 'KantoorOrderController@getOrderDetail');
Route::get('/beursmateriaal/order/detail/{id}', 'BeursOrderController@getOrderDetail');

// USERDATA

Route::get('/userdata', function(){
	return Auth::user();
});
