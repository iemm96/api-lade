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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']],function() {


});

Route::get('products/getProducts/{conExistencia}/{descripcion}/{clase}/{lugar}', 'ProductsController@getProducts');
Route::get('products/getProductsOrder/{numeroPedido}', 'ProductsController@getProductsOrder');

Route::get('orders/getOrders/{email}/{numeroPedido}/{status}/{anio}/{mes}', 'OrdersController@getOrders');
Route::get('orders/getOrderDetail/{numeroPedido}', 'OrdersController@getOrderDetail');

Route::post('login','LoginController@login');