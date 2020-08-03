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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::select('SELECT GETDATE() ');

        $result = [
            'clave' => '',
            'clase' => '',
            'descripcion' => '',
            'unidadMedida' => '',
            'precio' => '',
            'lugar' => '',
            'existencia' => '',
            'fechaUltimaModificacion' => '',
        ];

        return response()->json($result);
        //DB::select('exec my_stored_procedure(?,?,..)',array($Param1,$param2));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }
}
