<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReferenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('layouts/busqueda');
    }

    public function Buscarlc(Request $request){

        $LineaCaptura =$request->input('lineacaptura') ;
       dd($LineaCaptura);
    }

}
