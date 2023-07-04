<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        $linea_captura = $request->lineacaptura;
        if ($linea_captura == null) {
            $info=DB::table('users')->where('name', '=', $linea_captura)->get();
            return view('layouts/busqueda', ['info' => $info]);
        }else{
            $info = DB::table('users')->get();
            return view('layouts/busqueda', ['info' => $info]);
        }
    }

    public function Buscarlc(Request $request){

        $LineaCaptura =$request->input('lineacaptura') ;
       dd($LineaCaptura);
    }

}
