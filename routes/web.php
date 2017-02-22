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

Route::get('/logout', 'HomeController@logout');

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

Route::get('/overzicht', function(){
	return view('pages.orders.index');
});

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

Route::get('/promomateriaal/order/delete/{id}', 'PromoOrderController@destroy');
Route::get('/kantoormateriaal/order/delete/{id}', 'KantoorOrderController@destroy');
Route::get('/beursmateriaal/order/delete/{id}', 'BeursOrderController@destroy');

// USERDATA

Route::get('/userdata', function(){
	return Auth::user();
});

// Emailsignatures

Route::get('/emailhandtekeningen', 'EmailhandtekeningenController@index');
Route::get('/emailhandtekeningen/get', 'EmailhandtekeningenController@getEmailHandtekeningen');
Route::get('/emailhandtekeningen/download/{id}', 'EmailhandtekeningenController@downloadEmailHandtekening');
Route::get('/emailhandtekeningen/delete/{id}', 'EmailhandtekeningenController@destroy');
Route::get('/functies', 'EmailhandtekeningenController@getFuncties');

Route::post('/emailhandtekeningen/create', 'EmailhandtekeningenController@store');


//ADMIN
Route::group(['prefix' => 'admin', 'middleware' => 'App\Http\Middleware\Admin'], function()
{

    Route::get('/overzicht', function()
    {
        return view('pages.admin.dashboard.index');
    });

    Route::get('/emailhandtekeningen', 'EmailhandtekeningenAdminController@index');
    Route::get('/emailhandtekeningen/unapproved', 'EmailhandtekeningenAdminController@getUnapproved');
    Route::get('/emailhandtekeningen/approve/{id}', 'EmailhandtekeningenAdminController@setApproved');
    Route::get('/emailhandtekeningen/delete/{id}', 'EmailhandtekeningenAdminController@removeEmailhandtekening');
    Route::post('/emailhandtekeningen/function/add', 'EmailhandtekeningenAdminController@addFunction');
    Route::post('/emailhandtekeningen/function/save', 'EmailhandtekeningenAdminController@saveNewFunction');

    Route::get('/promomateriaal', 'PromoMateriaalAdminController@index');
    Route::get('/promomateriaal/all', 'PromoMateriaalController@getAll');
    Route::post('/promomateriaal/update', 'PromoMateriaalAdminController@update');

    Route::get('/kantoormateriaal', 'KantoorMateriaalAdminController@index');
    Route::get('/kantoormateriaal/all', 'KantoorMateriaalController@getAll');
    Route::post('/kantoormateriaal/update', 'KantoorMateriaalAdminController@update');

    Route::get('/beursmateriaal', 'BeursMateriaalAdminController@index');
    Route::get('/beursmateriaal/unavailabilities/all', 'BeursMateriaalAdminController@getAllUnavailabilities');

    Route::get('/promomateriaal/orders', 'PromoOrderController@getAll');
    Route::get('/kantoormateriaal/orders', 'KantoorOrderController@getAll');
    Route::get('/beursmateriaal/orders', 'BeursOrderController@getAll');

    Route::get('/promomateriaal/orders/{status}', 'PromoOrderController@getAllByStatus');
    Route::get('/kantoormateriaal/orders/{status}', 'KantoorOrderController@getAllByStatus');
    Route::get('/beursmateriaal/orders/{status}', 'BeursOrderController@getAllByStatus');

    Route::get('/kantoren', 'OfficeAdminController@index');
    Route::get('/kantoren/all', 'OfficeAdminController@getAll');
    Route::post('/kantoren/update', 'OfficeAdminController@update');

});

Route::group(['prefix' => 'dm', 'middleware' => 'App\Http\Middleware\Dm'], function()
{
    Route::get('/mijn-kantoren', 'DmController@index');
    Route::get('/data', 'DmController@data');
    Route::get('/offices', 'DmController@getOffices');

    Route::get('/promomateriaal/orders/{user_id}', 'DmController@getPromoOrders');
    Route::get('/kantoormateriaal/orders/{user_id}', 'DmController@getKantoorOrders');
    Route::get('/beursmateriaal/orders/{user_id}', 'DmController@getBeursOrders');

    Route::post('/kantoren/update', 'DmController@update');
});
