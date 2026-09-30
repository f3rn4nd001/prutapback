<?php

namespace App\Http\Controllers\Gateway\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\seg\objetArray;
use App\Http\Controllers\seg\encriptar;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Sistemas\permisos as Permisos;
use App\Http\Controllers\seg\tokenIp;

class permisos extends Controller
{
    public function getDetalles(Request $request){
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
        $instancia = new Permisos();
        $mongo = $instancia->getDetalles($request);
        return($mongo);
    }

    public function postRegistro(Request $request){
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
            $instancia = new Permisos();
            $mongo = $instancia->postRegistro($request);
            return($mongo);
    }
}
