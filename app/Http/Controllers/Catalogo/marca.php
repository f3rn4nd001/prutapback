<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\seg\encriptar;
use App\Http\Controllers\seg\objetArray;
use App\Models\catmarca;
use App\Models\catestatus;
use App\Models\relmarcamodelo;
use App\Models\catmodelo;

class marca extends Controller
{
    public function getComprementos(Request $request){
        $encriptar = new encriptar();
        $objetArray = new objetArray();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json               = isset($jsonX->filtros) ? $jsonX->filtros : [];
        $metodos            = isset($jsonX->metodos) ? $jsonX->metodos : [];
        if (is_array($json) || is_object($json)){
            $result = array();
            foreach ($json as $key => $value){
                $result[$key] = $objetArray->objeto_a_array($value);
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
       
        $sql = catmarca::query()
        ->when(!empty($ecodMarca), fn($q) => $q->where('ecodMarca', 'like', "%$ecodMarca%"))
        ->when(!empty($tNombre), fn($q) => $q->where('tNombre', 'like', "%$tNombre%"))
        ->when(!empty($ecodEstatus), fn($q) => $q->where('ecodEstatus', 'like', "%$ecodEstatus%"))
        ->orderBy($metodos->tMetodoOrdenamiento ?? 'ecodMarca', $metodos->orden ?? 'asc')
        ->limit($metodos->eNumeroRegistros ?? 10)
        ->get();
        $arrsql = [];
       
        if($sql->count() > 0){
            foreach ($sql as $key => $v){
                if (catestatus::where('ecodEstatus',$v->ecodEstatus)->value('tNombre') == 'Activo') {
                    $arrsql[]=array(
                        'ecodMarca' => $v->ecodMarca,
                        'tNombre'=> $v->tNombre,
                    );
                }
            } 
        }
        $jsonData = json_encode($arrsql);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json( $returResponse); 
    }

    public function getComprementosRelMarcaModelo(Request $request){
          }
}
