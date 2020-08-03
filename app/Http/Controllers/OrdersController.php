<?php

namespace App\Http\Controllers;

use App\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{


    public function getOrders(Request $request) {

        if(!$request->route('email')) {
            return response()->json('Error "correoAgente" es requerido');

        }

        $result = DB::select("exec getorders 
        '{$request->route('email')}','{$request->route('numeroPedido')}','{$request->route('status')}','{$request->route('anio')}','{$request->route('mes')}'");
        return response()->json($result);
    }

    public function getOrderDetail(Request $request) {

        if(!$request->route('numeroPedido')) {
            return response()->json('Error "numeroPedido" es requerido');
        }

        $result = DB::select("exec getorderdetail '{$request->route('numeroPedido')}'");
        return response()->json($result);
    }

}
