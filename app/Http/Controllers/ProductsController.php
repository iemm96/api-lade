<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function getProducts(Request $request) {

        if(!$request->route('conExistencia')) {
            return response()->json('Error "conExistencia" es requerido');
        }

        $result = DB::select("exec getProducts 
        {$request->route('conExistencia')},'{$request->route('descripcion')}',
        '{$request->route('clase')}','{$request->route('lugar')}'");
        return response()->json($result);
    }

    public function getProductsOrder(Request $request) {

        if(!$request->route('numeroPedido')) {
            return response()->json('Error "numeroPedido" es requerido');
        }

        $result = DB::select("exec getProductsOrder '{$request->route('numeroPedido')}'");
        return response()->json($result);
    }

}
