<?php

namespace App\Http\Controllers\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\catmenu;
use App\Models\catsubmenu;
use App\Models\catcontroller;
use App\Models\relmenusubmenucontroller;
use App\Http\Controllers\seg\encriptar;
use App\Http\Controllers\seg\objetArray;

class relrutas extends Controller
{
    public function getRegistro(Request $request){
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json               = isset($jsonX->filtros) ? $jsonX->filtros : [];
        $metodos            = isset($jsonX->metodos) ? $jsonX->metodos : [];
        if (is_array($json) || is_object($json)){
            $result = array();
            foreach ($json as $key => $value){
                $result[$key] = $this->objeto_a_array($value);
            }
            $result; 
        }

        foreach ($result as $key => $value) {
            if(array_key_exists($key, $result) ){
				if ($value != ''){
					${$key} =$value ;
				}
			}
        }

        $sqlMenu = relmenusubmenucontroller::get();
        foreach ($sqlMenu as $key => $v){
            $arrsqlmenu[]=array(
                'tNombreMenu'=> catmenu::where('ecodMenu',$v->ecodMenu)->value('tNombre'),
                'tNombreSubMenu'=> catsubmenu::where('ecodSubmenu',$v->ecodSubmenu)->value('tNombre'),
                'urlSubMenu'=> catsubmenu::where('ecodSubmenu',$v->ecodSubmenu)->value('tUrl'),
                'tNombreController'=> catcontroller::where('ecodControler',$v->ecodController)->value('tNombre'),
                'urlController'=> catcontroller::where('ecodControler',$v->ecodController)->value('tUrl'),
                'ecodMenu'=>$v->ecodMenu,
                'ecodSubmenu'=>$v->ecodSubmenu,
                'ecodControler'=>$v->ecodControler,
                
                
            );
        } 
        $jsonData = json_encode($arrsqlmenu);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json( $returResponse); 
       
     }
}
