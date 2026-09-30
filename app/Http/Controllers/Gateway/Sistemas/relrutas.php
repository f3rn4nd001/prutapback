<?php

namespace App\Http\Controllers\Gateway\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\seg\objetArray;
use App\Http\Controllers\seg\encriptar;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Sistemas\relrutas as Rutas;
use App\Http\Controllers\seg\tokenIp;

class relrutas extends Controller
{
    public function getRegistro(Request $request){
        $encriptar = new encriptar();
        $objetArray = new objetArray();
        $datos =json_decode($encriptar->shiftText($request['headers'], -23)) ;
        if (is_array($datos) || is_object($datos)){
            $result = array();
            foreach ($datos as $key => $value){
                $result[$key] = $objetArray->objeto_a_array($value);
            }
            $result; 
        }
            $instancia = new Rutas();
            $mongo = $instancia->getRegistro($request);
            return($mongo);
        
            /* por si impremento los bloqueos
            $tokenIp = new tokenIp();
            $key = $tokenIp->tokemIp($request);
            $intentos = Cache::get('servicios:' . $key);
            //se bloquea la ip si no cuenta con servicios
            if ($intentos >= 2) {
                Cache::put('bloqueado:' . $key, true);
            }
            $intentos = Cache::increment('servicios:' .$key);
            $data = [
                'mensaje'=>"Usuario invalido, No cuenta con los permisos",
            ];
            $jsonData = json_encode($data);
            $returResponse =$encriptar->shiftText($jsonData, 23);
            return response()->json($returResponse,401); 
        */
    }

}
