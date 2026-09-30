<?php

namespace App\Http\Controllers\Transportista\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\seg\encriptar;
use Illuminate\Support\Facades\DB;
use App\Models\relmenusubmenucontroller;

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
        $sql = relmenusubmenucontroller::query()
        ->leftJoin('catmenu as cm', 'cm.ecodMenu', '=', 'relmenusubmenucontroller.ecodMenu')
        ->leftJoin('catsubmenu as cs', 'cs.ecodSubmenu', '=', 'relmenusubmenucontroller.ecodSubmenu')
        ->leftJoin('catcontroller as cc', 'cc.ecodControler', '=', 'relmenusubmenucontroller.ecodController')
        ->leftJoin('catestatus as cesm', 'cesm.ecodEstatus', '=', 'cs.ecodEstatus')
        ->leftJoin('catestatus as cect', 'cect.ecodEstatus', '=', 'cc.ecodEstatus')
        ->select([
            'relmenusubmenucontroller.ecodMenu',
            'relmenusubmenucontroller.ecodSubmenu',
            'relmenusubmenucontroller.ecodController',
            'cm.tNombre as tNombreMenu',
            'cs.tNombre as tNombreSubMenu',
            'cc.tNombre as tNombreController'
        ])
        ->where('cesm.tNombre', '=', 'Activo')
        ->where(function ($q) {
            $q->whereNull('relmenusubmenucontroller.ecodController')
            ->orWhere('cect.tNombre', '=', 'Activo');
        })
        ->orderBy('cm.tNombre', 'ASC')
        ->orderBy('cs.tNombre', 'ASC')
        ->get();        

        $jsonData = json_encode($sql);
        $returResponse =$encriptar->shiftText($jsonData, 23);  
        return response()->json( $returResponse);  
    }
}
