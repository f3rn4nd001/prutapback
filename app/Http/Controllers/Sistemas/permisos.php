<?php

namespace App\Http\Controllers\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\seg\encriptar;
use Illuminate\Support\Facades\DB;
use App\Models\relusuariomenusubmenucontroller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Ramsey\Uuid\Uuid;
use App\Models\catmenu;
use App\Models\catsubmenu;
use App\Models\catcontroller;

class permisos extends Controller
{
    public function getDetalles(Request $request){
         $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = (isset($jsonX->data)&&$jsonX->data!="" ? "".(trim($jsonX->data))."":   Null);
        
         $selectRelUsuarioPermisos = relusuariomenusubmenucontroller::where('ecodUsuario', $json)->get();
        foreach ($selectRelUsuarioPermisos as $key => $v){
            $arrsqlmenu[]=array(
                'ecodMenu'=>$v->ecodMenu,
                'ecodSubmenu'=>$v->ecodSubmenu,
                'ecodController'=>$v->ecodController,
                'tNombreMenu'=> catmenu::where('ecodMenu',$v->ecodMenu)->value('tNombre'),
                'tNombreSubMenu'=> catsubmenu::where('ecodSubmenu',$v->ecodSubmenu)->value('tNombre'),
                'tNombreController'=> catcontroller::where('ecodControler',$v->ecodController)->value('tNombre'),
                
            );
        } 
    
        $jsonData = json_encode($arrsqlmenu);
        $returResponse =$encriptar->shiftText($jsonData, 23);        
        return response()->json($returResponse);
    }

}
