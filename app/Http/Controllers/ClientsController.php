<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function getClients() {
        $result = DB::select("exec getClients");
        return response()->json($result);
    }
}
