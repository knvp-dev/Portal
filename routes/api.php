<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/offices', 'AppController@getOffices');
Route::get('/orders/{office_id}', 'AppController@getOpenOrdersForOffice');

Route::get('/order/products/promo/{order_id}', 'AppController@getProductsForPromoOrder');
Route::get('/order/products/kantoor/{order_id}', 'AppController@getProductsForKantoorOrder');
Route::get('/order/products/beurs/{order_id}', 'AppController@getProductsForBeursOrder');

Route::get('/order/promo/complete/{order_id}', 'AppController@completePromoOrder');
Route::get('/order/kantoor/complete/{order_id}', 'AppController@completeKantoorOrder');
Route::get('/order/beurs/complete/{order_id}', 'AppController@completeBeursOrder');

Route::get('/order/product/deplete/promo/{order_id}/{product_id}', 'AppController@cannotDeliverPromoProduct');
Route::get('/order/product/deplete/kantoor/{order_id}/{product_id}', 'AppController@cannotDeliverKantoorProduct');
Route::get('/order/product/deplete/beurs/{order_id}/{product_id}', 'AppController@cannotDeliverBeursProduct');

Route::get('/reservations', 'AppController@getAllReservations');