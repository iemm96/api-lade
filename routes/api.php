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

//Protected Routes
Route::group(['middleware' => ['auth:api']],function() {

    //Ruta para obtener los productos por parámetros
    Route::get('products/getProducts/{conExistencia}', 'ProductsController@getProducts');

    //Ruta para obtener la orden de un producto por número de pedido
    Route::get('products/getProductsOrder/{numeroPedido}', 'ProductsController@getProductsOrder');

    //Ruta para obtener las órdenes por email del vendedor
    Route::get('orders/getOrders/{email}', 'OrdersController@getOrders');

    //Ruta para obtener el detalle de la orden por número de pedido
    Route::get('orders/getOrderDetail/{numeroPedido}', 'OrdersController@getOrderDetail');

    //Ruta para obtener el detalle de los clientes
    Route::get('clients/getClients', 'ClientsController@getClients');


});

//Login Route
Route::post('login','Auth\LoginController@login');

//Ruta para registrar un nuevo usuario en la tabla users
Route::post('users/register', 'UserController@register');