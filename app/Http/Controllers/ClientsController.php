<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function getClients(Request $request) {

        /*
        if(!$request->route('numeroPedido')) {
            return response()->json('Error "numeroPedido" es requerido');
        }*/

        $result = DB::select("exec getClients");
        return response()->json($result);
    }
}
