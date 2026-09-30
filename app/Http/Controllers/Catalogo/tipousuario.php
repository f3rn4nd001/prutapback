<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cattipousuario;
use DB;
use App\Models\catusuario;
use App\Http\Controllers\seg\encriptar;
use App\Http\Controllers\seg\objetArray;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use App\Models\logcattipousuario;
use App\Models\relusuariocorreo;
class tipousuario extends Controller
{
    public function getRegistro(Request $request){
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
        $sql = cattipousuario::query()
        ->when(!empty($ecodTipoUsuario), fn($q) => $q->where('ecodTipoUsuario', 'like', "%$ecodTipoUsuario%"))
        ->when(!empty($tNombre), fn($q) => $q->where('tNombre', 'like', "%$tNombre%"))
        ->orderBy($metodos->tMetodoOrdenamiento ?? 'ecodProductos', $metodos->orden ?? 'asc')
        ->limit($metodos->eNumeroRegistros ?? 10)
        ->get();
        
        if($sql->count() < 1){
            $data = [
                'mensaje'=>"No se econtro datos",
            ];
            $jsonData = json_encode($data);
            $returResponse =$encriptar->shiftText($jsonData, 23);
            return response()->json($returResponse,202); 
        }

        foreach ($sql as $key => $v){
            $arrsql[]=array(
                'ecodTipoUsuario' => $v->ecodTipoUsuario,
                'tNombre'=> $v->tNombre,
                'fhCreacion' => $v->fhCreacion->format('d/m/Y H:i'),
            );
        } 
        $jsonData = json_encode($arrsql);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json( $returResponse); 
    }

    public function getDetalles(Request $request){
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = (isset($jsonX->data)&&$jsonX->data!="" ? "".(trim($jsonX->data))."":   Null);
        
        $sql = cattipousuario::where('ecodTipoUsuario',$json)->get(); 
        foreach ($sql as $key => $v){
            $arrsql[]=array(
                'ecodTipoUsuario' => $v->ecodTipoUsuario,
                'tNombre' => $v->tNombre,
                'ecodCreacion' => $v->ecodCreacion,
                'fhCreacion' => $v->fhCreacion->format('d/m/Y H:i'),
                'nombresEditor' => catusuario::raw(function($collection) use ($v) {
                    return $collection->aggregate([
                        [
                            '$match' => [
                                'ecodUsuario' => $v->ecodEdicion
                            ]
                        ],
                        [
                            '$project' => [
                                'NombreCompleto' => [
                                    '$concat' => ['$tNombre', ' ', '$tApellido']
                                ],
                              
                            ]
                        ]
                    ]);
                })->value('NombreCompleto'),
                'nombresCreador' => catusuario::raw(function($collection) use ($v) {
                    return $collection->aggregate([
                        [
                            '$match' => [
                                'ecodUsuario' => $v->ecodCreacion
                            ]
                        ],
                        [
                            '$project' => [
                                'NombreCompleto' => [
                                    '$concat' => ['$tNombre', ' ', '$tApellido']
                                ],
                              
                            ]
                        ]
                    ]);
                })->value('NombreCompleto')
            );
        }
        $data = ['sqlPerfiles'=>(isset($arrsql[0]) ? $arrsql[0] : "")];
        $jsonData = json_encode($data);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse);
    }
 
    public function postRegistro(Request $request){
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = isset($jsonX->Perfiles) ? $jsonX->Perfiles : [];
        $jsonH =json_decode($encriptar->shiftText($request['headers'], -23));
        $jsonarrCorreo  = isset($json->arrCorreo) ? $json->arrCorreo : [];
        $data = [];
      
        if (isset($json->tNombre)) $data['tNombre'] = trim($json->tNombre, '');
        $ecodTipoUsuario = (isset($json->ecodTipoUsuario)&&$json->ecodTipoUsuario!="" ? "".(trim($json->ecodTipoUsuario))."":   Null);
        $ecodCorreo = trim($jsonH->ecodCorreo, '"');
        if ($ecodTipoUsuario == Null) {
            $uuiecod = Uuid::uuid4();
            $data['ecodTipoUsuario'] = (isset($uuiecod)&&$uuiecod!="" ? "".(trim($uuiecod))."":   Null);
            $data['fhCreacion'] = Carbon::now();
            $data['ecodCreacion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
            $existeCorreo = cattipousuario::where('tNombre', $data['tNombre'])->exists();
            if (!$existeCorreo) {
                cattipousuario::insert($data);
                $response = $data['ecodTipoUsuario'];
            }
            else {
                $data = [
                    'mensaje'=>"Dato dupricado",
                ];
                $jsonData = json_encode($data);
                $returResponse2 =$encriptar->shiftText($jsonData, 23);
                return response()->json($returResponse2,202);
            }
        }
        else {
           $sqlcattipousuario = cattipousuario::where('tNombre', $data['tNombre'])->get();    
           if ($sqlcattipousuario->isNotEmpty()) {
            if ($sqlcattipousuario[0]->ecodTipoUsuario == $ecodTipoUsuario) {
                    $this->logs($ecodTipoUsuario);
                    $data['fhEdicion'] = Carbon::now();
                    $data['ecodEdicion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
                    cattipousuario::where('ecodTipoUsuario',$ecodTipoUsuario)->update($data);
                    $response=$ecodTipoUsuario;
                }
                else {
                    $data = [
                        'mensaje'=>"Dato dupricado",
                    ];
                    $jsonData = json_encode($data);
                    $returResponse2 =$encriptar->shiftText($jsonData, 23);
                    return response()->json($returResponse2,202);
                }
            }
            else {
                $this->logs($ecodTipoUsuario);
                $data['fhEdicion'] = Carbon::now();
                $data['ecodEdicion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
                cattipousuario::where('ecodTipoUsuario',$ecodTipoUsuario)->update($data);
                $response=$ecodTipoUsuario;
            }            
        }
        $jsonData = json_encode($response);
        $returResponse2 =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse2);
    }

    public function postEliminar(Request $request){
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = isset($jsonX->formGroup) ? $jsonX->formGroup : [];
        $jsonH =json_decode($encriptar->shiftText($request['headers'], -23));

        $ecod = (isset($jsonX->ecod)&&$jsonX->ecod!="" ? "".(trim($jsonX->ecod))."":   Null);
        $ecodCorreo = trim($jsonH->ecodCorreo, '"');
        $sqllog = $this->logs($ecod);
        
        $sqllog['ecodEdicion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
        $sqllog['$tMotivoEliminacon'] = (isset($json->mEliminacion)&&$json->mEliminacion!="" ? "".(trim($json->mEliminacion))."":   Null);
        $loguuid = Uuid::uuid4();
        $sqllog['ecodLogTipoUsuario'] = (isset($loguuid)&&$loguuid!="" ? "".(trim($loguuid))."":   Null);
        logcattipousuario::insert($sqllog);
        cattipousuario::where('ecodTipoUsuario',$ecod)->delete();
        
        $data = [
            'mensaje'=>"Se elimino los datos relacionada a $ecod",
        ];
        
        $jsonData = json_encode($data);
        $returResponse2 =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse2,202);
    }

    public function logs($data) {
        $Logdata = [];
        $sqllog = cattipousuario::where('ecodTipoUsuario',$data)->get();
       
        if (isset($sqllog[0]->tNombre)&&$sqllog[0]->tNombre!="") $Logdata['tNombre'] = trim($sqllog[0]->tNombre, '');
        if (isset($sqllog[0]->fhCreacion)&&$sqllog[0]->fhCreacion!="") $Logdata['fhCreacion'] = trim($sqllog[0]->fhCreacion, '"');
        if (isset($sqllog[0]->ecodCreacion)&&$sqllog[0]->ecodCreacion!="") $Logdata['ecodCreacion'] = trim($sqllog[0]->ecodCreacion, '');
        if (isset($sqllog[0]->ecodEdicion)&&$sqllog[0]->ecodEdicion!="") $Logdata['ecodEdicion'] = trim($sqllog[0]->ecodEdicion, '');
        if (isset($sqllog[0]->fhEdicion)&&$sqllog[0]->fhEdicion!="") $Logdata['fhEdicion'] = trim($sqllog[0]->fhEdicion, '');
        
        $Logdata['ecodTipoUsuario'] = $data; 
        $uuiecodUsuario = Uuid::uuid4();
        $Logdata['ecodLogTipoUsuario'] = (isset($uuiecodUsuario)&&$uuiecodUsuario!="" ? "".(trim($uuiecodUsuario))."":   Null);
        logcattipousuario::insert($Logdata);
        return($Logdata);
    }
    
    public function getComprementos(Request $request) {
        $sqlact=cattipousuario::all('ecodTipoUsuario','tNombre'); 
        $encriptar = new encriptar();
        $returResponse = $encriptar->shiftText($sqlact, 23);
        return response()->json($returResponse);
    }
}
