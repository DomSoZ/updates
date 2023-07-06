<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReferenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    

    
    public function index(Request $request){
        $linea_captura = $request->input('lineacaptura') ?? 00;
        // dd($linea_captura);
        if ($linea_captura == null) {
            // mamadas del maicra
            $info=DB::table('users')->where('id', '=', $linea_captura)->get();
            // dd($info);
            return view('layouts/busqueda', ['consultarLc' => [], 'datos_update' => []]);
        }else{
            // CONSULTA A BD PAGOS
            $ConsultarLc=  \DB::connection('mysqlbanc2')->select("select * from  pagos p   WHERE numero_orden = ? ; ", [$linea_captura]);
            // dd( $ConsultarLc);
          
              $result=  $this->ConsumoWSDLValidarlc($linea_captura);
               // dd($result);
            //    dd( $result);

            //   if ( $result['ES_MSJ']['V1_MENS'] == 'No existe documento de compensación'){

            //     return view('layouts/busqueda', ['consultarLc' => [], 'resultados' => []]);

            //   }
               

               $resultdos=  $this->ConsumoWSDLConsultaRecibo($linea_captura,  $result['ES_ORDEN_PAGO']['IMPORTE']);
                //  dd($resultdos);
            

                if ($resultdos['TB_ConsultaRecibo']['ES_MENSAJES']['TpMens'] == "E"){
                    $estado = "I";
                    $metodopago = "";
                    $formapago = "" ;
                    $monto_pagado ="";
    
                }else{
                    $estado = "P";
                    $metodopago = $resultdos['TB_ConsultaRecibo']['MetodoPago'] ?? 00;
                    $formapago = $resultdos['TB_ConsultaRecibo']['FormaPago'] ;
                    $monto_pagado = $resultdos['TB_ConsultaRecibo']['Total'] ?? 00;
                }

                $datos_update= array(
                    "FORMA_PAGO" => $formapago ,
                    "RFC" => $result['ES_ORDEN_PAGO']['RFC'],
                    "METODO_PAGO"=>$metodopago,
                    "NUMERO_OPERACION"=> '00',
                    "BANCO"=> '',
                    "MONTO_PAGADO"=>$monto_pagado ,
                    "FECHA_PAGO"=> '',
                    "NUMERO_ORDEN"=> $linea_captura,
                    "ESTADO"=> $estado
                );

                $Bancos=  \DB::connection('mysqlbanc2')->select("select id_banco, banco from  c_bancos cb  ;");
                $convenios=  \DB::connection('mysqlbanc2')->select("  select id_convenio, cuenta_contable , via_pago   from  c_convenios cc ; ");
             //dd($G);
            // dd($result['MONTO']);



            return view('layouts/busqueda', ['consultarLc' => $ConsultarLc, 'datos_update' => $datos_update,'bancos' =>$Bancos, 'convenios' => $convenios]);
        }
    }

    private function ConsumoWSDLConsultaRecibo($linea_captura, $monto){

        $service=env("SERV_CONSULTA_RECIBO_FACT");
        $username=env("USER_SAP");
        $password=env("PASSWORD_SAP");
        $parametros=array(["TpUsuario"=> 2, "TpConsulta"=> 3 , "FolioConsulta"=>  $linea_captura, "Importe"=>   $monto ]);
        $funcion= "SI_ConsultaRecibo_PI_Sender";
       return  $result = $this->soap_client($service,$username,$password,$funcion,$parametros);
     
    }

    private function ConsumoWSDLValidarlc($linea_captura){


        $service=env("SERV_VALIDA_LC");
        $username=env("USER_SAP_VALIDA_LC");
        $password=env("PASSWORD_SAP_VALIDA_LC");
        $parametros=array(["NRO_ORD_PAGO" => $linea_captura, "NRO_DECLARACION"=>"", "TP_CONSULTA"=>"1" ]);
        $funcion= "SI_BuscarDetalleLineaCaptura_PI_Sender";
       return  $result = $this->soap_client($service,$username,$password,$funcion,$parametros);
     
    }

    private function ConsumoWSDLAltalc($linea_captura){


    //     $service=env("SERV_VALIDA_LC");
    //     $username=env("USER_SAP_VALIDA_LC");
    //     $password=env("PASSWORD_SAP_VALIDA_LC");
    //     $parametros=array(["TP_FOLIO"=> 2, "FOLIO"=> $linea_captura  ]);
    //     $funcion= "SI_ValidarLinCaptura_PI_Sender";
    //    return  $result = $this->soap_client($service,$username,$password,$funcion,$parametros);
     
    }

    private function soap_client($service,$username,$password,$funcion,$parametros)
    {
    try {
        $soapclient = new \nusoap_client($service, true);
        $soapclient->setCredentials($username, $password, 'basic');
        $soapclient->decode_utf8 = false;
        $soapclient->timeout = 10;
        $soapclient->response_timeout = 10;
        $result = $soapclient->call($funcion, $parametros);
        if ($sError = $soapclient->getError()) {
          return response()->json(array("mensaje" => "Error al consumir servicio".$sError), 500);
          
          }
        if ($soapclient->fault) {
            return array("mensaje" => "Error al consumir servicio");
        }
        // return response()->json( $result,200);;
        return $result;

        }catch(Exception $e){
            return array("mensaje" => "Error al consumir servicio");
        }
    } 

    public function update(Request $request){
        dd($request);
    }
}
