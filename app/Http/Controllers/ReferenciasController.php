<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

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
        //   dd($result['ES_ORDEN_PAGO']['LINEA_CAPTURA']);
            
                

            //   if ( $result['ES_MSJ']['V1_MENS'] == 'No existe documento de compensación'){

            //     return view('layouts/busqueda', ['consultarLc' => [], 'resultados' => []]);

            //   }
               

               $resultdos=  $this->ConsumoWSDLConsultaRecibo($linea_captura,  $result['ES_ORDEN_PAGO']['IMPORTE']);

            //    $numero_resultdos = sizeof($resultdos);
                //  dd(  $resultdos);

                 if(count( $resultdos['TB_ConsultaRecibo']) <= 5){

                    $paraif= $resultdos['TB_ConsultaRecibo'][0]['ES_MENSAJES']['TpMens'];
                    $estado = "P";
                    $FECHA_VENCE= date("Y-m-d", strtotime($result['ES_ORDEN_PAGO']['FECHA_VENCIMIENTO']));
                    $inea_cap= $result['ES_ORDEN_PAGO']['LINEA_CAPTURA'];
                    $metodopago = $resultdos['TB_ConsultaRecibo'][0]['MetodoPago'] ?? 00;
                    $formapago = $resultdos['TB_ConsultaRecibo'][0]['FormaPago'] ;
                    $monto_pagado = $resultdos['TB_ConsultaRecibo'][0]['Total'] ?? 00;
                 }else{
                     $paraif= $resultdos['TB_ConsultaRecibo']['ES_MENSAJES']['TpMens'] ;
                     $estado = "P";
                     $FECHA_VENCE= date("Y-m-d", strtotime($result['ES_ORDEN_PAGO']['FECHA_VENCIMIENTO']));
                     $inea_cap= $result['ES_ORDEN_PAGO']['LINEA_CAPTURA'];
                     $metodopago = $resultdos['TB_ConsultaRecibo']['MetodoPago'] ?? 00;
                     $formapago = $resultdos['TB_ConsultaRecibo']['FormaPago'] ;
                     $monto_pagado = $resultdos['TB_ConsultaRecibo']['Total'] ?? 00;
                 }
            

                if (  $paraif == "E"){
                    $estado = "I";
                    $metodopago = "";
                    $formapago = "" ;
                    $monto_pagado ="";
                    $FECHA_VENCE="";
                    $inea_cap="";
    
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
                    "ESTADO"=> $estado,
                    "FECHA_VENCE"=>$FECHA_VENCE,
                    "LINEA_CAPTURA"=> $inea_cap
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


    public function Insertlc(Request $request ){
        dd($request );
        $this-> ConsumoWSDLAltalc();
     
         
     }


    private function ConsumoWSDLAltalc($linea_captura, $RFC, $FECHA_VENCE, $MONTO, $NUMERO_ORDEN ){


    $service=env("SERV_ALTA");
    $username=env("USER_SAP_ALTA");
    $password=env("PASSWORD_SAP_ALTA");
    $parametros=array(["referencia"=> $linea_captura, "rfc"=> $RFC  , "fechaVencimiento"=> $FECHA_VENCE , "monto"=> $MONTO, "numeroOrden"=> $NUMERO_ORDEN, "engomado"=> "" ]);
   $funcion= "alta";
       return  $result = $this->soap_client($service,$username,$password,$funcion,$parametros);
     
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
    // dd($this->getToday());
     $FORMA_PAGO = $request['FORMA_PAGO']; $RFC = $request['RFC']; $METODO_PAGO = $request['METODO_PAGO'];
     $NUMERO_OPERACION = $request['NUMERO_OPERACION']; $MONTO_PAGADO = $request['MONTO_PAGADO'];
     $FECHA_PAGO = $request['FECHA_PAGO']; $NUMERO_ORDEN = $request['NUMERO_ORDEN']; $ESTADO = $request['ESTADO']; $BANCO=['BANCO'] ;$CONVENIO=['CONVENIO']; 
    
    $date=date_create( $FECHA_PAGO);
    $FECHA_PAGO = date_format($date,"Y-m-d H:i:s");
  
    dd($FECHA_PAGO);

    //   $UPDATE =  \DB::connection('mysqlbanc2')->select(" update pagos set pagos.estado= ?, pagos.id_forma_pago=? , pagos.metodo_pago=?, pagos.numero_operacion=?, 
    //                                                      pagos.rfc=?,  pagos.banco= ? , pagos.id_convenio = ?, pagos.monto_pagado=?	, pagos.fecha_pago= ? 
    //                                                      where pagos.numero_orden =?; ", [$ESTADO, $FORMA_PAGO, $METODO_PAGO, $NUMERO_OPERACION, $RFC, $BANCO, $MONTO_PAGADO,$FECHA_PAGO, $NUMERO_ORDEN ]);

    Bitacora::create([
        'id_usuario' =>  Auth::user()->id,
        'linea_captura' =>  $NUMERO_ORDEN, 
        'accion' =>  "UPDATE"
    ]);

    return view('layouts/busqueda', ['consultarLc' => [], 'datos_update' => []]);
}


// Private function getToday(){
//     date_default_timezone_set("America/Mexico_City");
//     return date("Y-m-d\TH:i:s");
// }

}
