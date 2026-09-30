<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\seg\encriptar;
use App\Http\Controllers\seg\objetArray;
use App\Models\catusuario;
use App\Models\catestatus;
use App\Models\relusuariocorreo;
use App\Models\Bitcorreo;
use App\Models\logcatusuarios;
use DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class usuario extends Controller
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
        if (!empty($estatus['ecodEstatus'])) {
            $ecodEstatus = $estatus['ecodEstatus'];
        }
        
        $sql = catusuario::query()
        ->when(!empty($ecodUsuario), fn($q) => $q->where('ecodUsuario', 'like', "%$ecodUsuario%"))
        ->when(!empty($tNombre), fn($q) => $q->whereRaw(['$expr' => ['$regexMatch' => ['input' => ['$concat' => ['$tNombre', ' ', '$tApellido']],'regex' => $tNombre,'options' => 'i']]]))
        ->when(!empty($tRFC), fn($q) => $q->where('tRFC', 'like', "%$tRFC%"))
        ->when(!empty($tCRUP), fn($q) => $q->where('tCRUP', 'like', "%$tCRUP%"))
        ->when(!empty($ecodEstatus), fn($q) => $q->where('ecodEstatus', 'like', "%$ecodEstatus%"))
        ->orderBy($metodos->tMetodoOrdenamiento ?? 'ecodUsuario', $metodos->orden ?? 'asc')
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
            $arrsqlusuario[]=array(
                'ecodUsuario' => $v->ecodUsuario,
                'tRFC' => $v->tRFC,
                'tNombre'=> trim($v->tNombre . ' ' . $v->tApellido),
                'tCRUP' => $v->tCRUP,
                'fhCreacion' => $v->fhCreacion->format('d/m/Y H:i'),
                'estatus'=> catestatus::where('ecodEstatus',$v->ecodEstatus)->value('tNombre')           
            );
        }       

        $jsonData = json_encode($arrsqlusuario);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json( $returResponse); 
    }

    public function getDetalles(Request $request){
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = (isset($jsonX->data)&&$jsonX->data!="" ? "".(trim($jsonX->data))."":   Null);
        
        $sqlUsusario = catusuario::where('ecodUsuario',$json)->get(); 

        foreach ($sqlUsusario as $key => $v){
            $arrsqlusuario[]=array(
                'ecodUsuario' => $v->ecodUsuario,
                'tRFC' => $v->tRFC,
                'Nombre' => trim($v->tNombre . ' ' . $v->tApellido),
                'tCRUP' => $v->tCRUP,
                'tNombre'=>$v->tNombre,
                'tApellido' => $v->tApellido,
                'fhCreacion' => $v->fhCreacion->format('d/m/Y H:i'),
                'Estatus' => catestatus::where('ecodEstatus',$v->ecodEstatus)->value('tNombre'),
                'tCRUP' => $v->tCRUP,
                'ecodEstatus'=>$v->ecodEstatus,
                'tRFC' => $v->tRFC,
                'nEdad' => $v->nEdad,
                'nTelefono' => $v->nTelefono,
                'tSexo' => $v->tSexo,
                'tNotas' => $v->tNotas,
                'iUsuario' => $v->iUsuario,
                'fhEdicion' => $v->fhEdicion,
                'ecodTipoUsuario'=>$v->ecodTipoUsuario,
                'ecodEdicion' => $v->ecodEdicion,
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

        $sqlCorreo = relusuariocorreo::where('ecodUsuario',$json)->get(); 
        foreach ($sqlCorreo as $key => $v){
            $arrsqlcorreo[]=array(
                'ecodCorreo' => $v->ecodCorreo,
                'tCorreo' => Bitcorreo::where('ecodCorreo',$v->ecodCorreo)->value('tCorreo'),
            );
        }
       
        $data = [
            'sqlUsusario'=>(isset($arrsqlusuario[0]) ? $arrsqlusuario[0] : ""),
            'sqlCorreo'=>(isset($arrsqlcorreo) ? $arrsqlcorreo : "")
        ];

        $jsonData = json_encode($data);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse);
    }


    public function postRegistro(Request $request){
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = isset($jsonX->Usuario) ? $jsonX->Usuario : [];
        $jsonH =json_decode($encriptar->shiftText($request['headers'], -23));
        $jsonarrCorreo  = isset($json->arrCorreo) ? $json->arrCorreo : [];
        $data = [];
        if (isset($json->tNombre)) $data['tNombre'] = trim($json->tNombre, '');
        if (isset($json->tApellido)) $data['tApellido'] = trim($json->tApellido, '');
        if (isset($json->tCRUP)&&$json->tCRUP!="") $data['tCRUP'] = trim($json->tCRUP, '');
        if (isset($json->tSexo)&&$json->tSexo!="") $data['tSexo'] = trim($json->tSexo, '');
        if (isset($json->nEdad)&&$json->nEdad!="") $data['nEdad'] = intval($json->nEdad);
        if (isset($json->nLada)&&$json->nLada!="") $data['nLada'] = intval($json->nLada);
        if (isset($json->nTelefono)&&$json->nTelefono!="") $data['nTelefono'] = intval($json->nTelefono);
        if (isset($json->fhNacimiento)&&$json->fhNacimiento!="") $data['fhNacimiento'] = trim($json->fhNacimiento, '"');
        if (isset($json->tRFC)&&$json->tRFC!="") $data['tRFC'] = trim($json->tRFC, '"');
        if (isset($json->iUsuario)&&$json->iUsuario!="") $data['iUsuario'] = trim($json->iUsuario, '"');
        if (isset($json->tNotas)&&$json->tNotas!="") $data['tNotas'] = trim($json->tNotas, '"');
        if (isset($json->ecodEstatus)&&$json->ecodEstatus!="") $data['ecodEstatus'] = trim($json->ecodEstatus, '"');
        if (isset($json->ecodTipoUsuario)&&$json->ecodTipoUsuario!="") $data['ecodTipoUsuario'] = trim($json->ecodTipoUsuario, '"');
        $ecodUsuario = (isset($json->ecodUsuario)&&$json->ecodUsuario!="" ? "".(trim($json->ecodUsuario))."":   Null);
        $ecodCorreo = trim($jsonH->ecodCorreo, '"');

        if ($ecodUsuario == Null) {
            $uuiecodUsuario = Uuid::uuid4();
            $data['ecodUsuario'] = (isset($uuiecodUsuario)&&$uuiecodUsuario!="" ? "".(trim($uuiecodUsuario))."":   Null);
            $data['fhCreacion'] = Carbon::now();
            $data['ecodEstatus'] = "2660376e-dbf8-44c1-b69f-b2554e3e5d4c";
            $data['ecodCreacion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
            catusuario::insert($data);
            if (count($jsonarrCorreo) > 0) {
                foreach ($jsonarrCorreo as $key => $value) {
                    $uuiecodCorreo = Uuid::uuid4();   
                    $uuid2uuiecodCorreo = (isset($uuiecodCorreo)&&$uuiecodCorreo!="" ? "".(trim($uuiecodCorreo))."":   Null);
                    $tCorreo  = (isset($value->tCorreo)&&$value->tCorreo!=""            ? "".(trim($value->tCorreo))."":   Null);
                    $tContrasena  = (isset($value->tContrasena)&&$value->tContrasena!=""            ? bcrypt(trim($value->tContrasena)):   Null);  

                    $existeCorreo = Bitcorreo::where('tCorreo', $tCorreo)->exists();
                    if (!$existeCorreo) {
                        Bitcorreo::insert([
                            'ecodCorreo'=> $uuid2uuiecodCorreo,
                            'tCorreo'=> $tCorreo,
                            'tpassword'=> $tContrasena,
                        ]);
                    }

                    $uuiecodRelUsuarioCorreo = Uuid::uuid4();
                    $uuid2uuiecodRelUsuarioCorreo = (isset($uuiecodRelUsuarioCorreo)&&$uuiecodRelUsuarioCorreo!="" ? "".(trim($uuiecodRelUsuarioCorreo))."":   Null);
                    $ecodUsuario = $data['ecodUsuario'];

                    relusuariocorreo::insert([
                        'ecodRelUsuarioCorreo'=> $uuid2uuiecodRelUsuarioCorreo,
                        'ecodCorreo'=> $uuid2uuiecodCorreo,
                        'ecodUsuario'=> $ecodUsuario,
                    ]);
                }
            } 
            $responseUsuario = $data['ecodUsuario'];
        }
        else {
            $this->logs($ecodUsuario);
            $data['fhEdicion'] = Carbon::now();
            $data['ecodEstatus'] = (isset($json->ecodEstatus)&&$json->ecodEstatus!="" ? "".(trim($json->ecodEstatus))."":   Null);
            $data['ecodEdicion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
            catusuario::where('ecodUsuario',$ecodUsuario)->update($data);
            if (count($jsonarrCorreo) > 0) {
                foreach ($jsonarrCorreo as $key => $value) {
                    $tCorreo  = (isset($value->tCorreo)&&$value->tCorreo!=""   ? "".(trim($value->tCorreo))."":   Null);
                    $ecodCorreo  = (isset($value->ecodCorreo)&&$value->ecodCorreo!=""   ?   "".(trim($value->ecodCorreo))."":  Null);  
                    if ($ecodCorreo == Null) {
                        $existeCorreo = Bitcorreo::where('tCorreo', $tCorreo)->exists();
                        if (!$existeCorreo) {
                            $uuiecodCorreo = Uuid::uuid4();
                            $uuid2uuiecodCorreo = (isset($uuiecodCorreo)&&$uuiecodCorreo!="" ? "".(trim($uuiecodCorreo))."":   Null);
                            $tContrasena  = (isset($value->tContrasena)&&$value->tContrasena!=""            ? bcrypt(trim($value->tContrasena)):   Null);  
                            Bitcorreo::insert([
                                'ecodCorreo'=> $uuid2uuiecodCorreo,
                                'tCorreo'=> $tCorreo,
                                'tpassword'=> $tContrasena,
                            ]);

                            $uuiecodRelUsuarioCorreo = Uuid::uuid4();
                            $uuid2uuiecodRelUsuarioCorreo = (isset($uuiecodRelUsuarioCorreo)&&$uuiecodRelUsuarioCorreo!="" ? "".(trim($uuiecodRelUsuarioCorreo))."":   Null);
        
                            relusuariocorreo::insert([
                                'ecodRelUsuarioCorreo'=> $uuid2uuiecodRelUsuarioCorreo,
                                'ecodCorreo'=> $uuid2uuiecodCorreo,
                                'ecodUsuario'=> $ecodUsuario,
                            ]);
                        }
                    }
                    else {
                        Bitcorreo::where('ecodCorreo',$ecodCorreo)->update([
                            'tCorreo' => $tCorreo
                        ]);
                    }
                }
            }
            $responseUsuario=$ecodUsuario;
        }
        $jsonData = json_encode($responseUsuario);
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
        $sqllog['ecodEdicion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
        $sqllog['$tMotivoEliminacon'] = (isset($json->mEliminacion)&&$json->mEliminacion!="" ? "".(trim($json->mEliminacion))."":   Null);

        $sqllog = $this->logs($ecod);
        $sqllog['ecodEstatus'] = "fa6cc9a2-f221-4e27-b575-1fac2698d27a";
        $loguuid = Uuid::uuid4();
        $sqllog['ecodLogUsuario'] = (isset($loguuid)&&$loguuid!="" ? "".(trim($loguuid))."":   Null);
        logcatusuarios::insert($sqllog);

        catusuario::where('ecodUsuario',$ecod)->delete();
        $ecodCorreo = relusuariocorreo::where('ecodUsuario',$ecod)->get(); 
        foreach ($ecodCorreo as $key => $value) {
            relusuariocorreo::where('ecodRelUsuarioCorreo',$value->ecodRelUsuarioCorreo)->delete(); 
            Bitcorreo::where('ecodCorreo',$value->ecodCorreo)->delete(); 
        }
        $data = [
            'mensaje'=>"Se elimino los datos relacionada a $ecod",
        ];
        $jsonData = json_encode($data);
        $returResponse2 =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse2,202);
    }

    // logs -> insert de logs usuarios
    public function logs($data) {
        $Logdata = [];
        $sqllogCatUsuario = catusuario::where('ecodUsuario',$data)->get();
        if (isset($sqllogCatUsuario[0]->tNombre)&&$sqllogCatUsuario[0]->tNombre!="") $Logdata['tNombre'] = trim($sqllogCatUsuario[0]->tNombre, '');
        if (isset($sqllogCatUsuario[0]->tApellido)&&$sqllogCatUsuario[0]->tApellido!="") $Logdata['tApellido'] = trim($sqllogCatUsuario[0]->tApellido, '');
        if (isset($sqllogCatUsuario[0]->tCRUP)&&$sqllogCatUsuario[0]->tCRUP!="") $Logdata['tCRUP'] = trim($sqllogCatUsuario[0]->tCRUP, '');
        if (isset($sqllogCatUsuario[0]->tSexo)&&$sqllogCatUsuario[0]->tSexo!="") $Logdata['tSexo'] = trim($sqllogCatUsuario[0]->tSexo, '');
        if (isset($sqllogCatUsuario[0]->nEdad)&&$sqllogCatUsuario[0]->nEdad!="") $Logdata['nEdad'] = intval($sqllogCatUsuario[0]->nEdad);
        if (isset($sqllogCatUsuario[0]->nLada)&&$sqllogCatUsuario[0]->nLada!="") $Logdata['nLada'] = intval($sqllogCatUsuario[0]->nLada);
        if (isset($sqllogCatUsuario[0]->nTelefono)&&$sqllogCatUsuario[0]->nTelefono!="") $Logdata['nTelefono'] = intval($sqllogCatUsuario[0]->nTelefono);
        if (isset($sqllogCatUsuario[0]->fhNacimiento)&&$sqllogCatUsuario[0]->fhNacimiento!="") $Logdata['fhNacimiento'] = trim($sqllogCatUsuario[0]->fhNacimiento, '"');
        if (isset($sqllogCatUsuario[0]->tRFC)&&$sqllogCatUsuario[0]->tRFC!="") $Logdata['tRFC'] = trim($sqllogCatUsuario[0]->tRFC, '"');
        if (isset($sqllogCatUsuario[0]->iUsuario)&&$sqllogCatUsuario[0]->iUsuario!="") $Logdata['iUsuario'] = trim($sqllogCatUsuario[0]->iUsuario, '"');
        if (isset($sqllogCatUsuario[0]->tNotas)&&$sqllogCatUsuario[0]->tNotas!="") $Logdata['tNotas'] = trim($sqllogCatUsuario[0]->tNotas, '"');
        if (isset($sqllogCatUsuario[0]->ecodEstatus)&&$sqllogCatUsuario[0]->ecodEstatus!="") $Logdata['ecodEstatus'] = trim($sqllogCatUsuario[0]->ecodEstatus, '"');
        if (isset($sqllogCatUsuario[0]->ecodTipoUsuario)&&$sqllogCatUsuario[0]->ecodTipoUsuario!="") $Logdata['ecodTipoUsuario'] = trim($sqllogCatUsuario[0]->ecodTipoUsuario, '"');
        if (isset($sqllogCatUsuario[0]->fhCreacion)&&$sqllogCatUsuario[0]->fhCreacion!="") $Logdata['fhCreacion'] = trim($sqllogCatUsuario[0]->fhCreacion, '"');
        if (isset($sqllogCatUsuario[0]->ecodCreacion)&&$sqllogCatUsuario[0]->ecodCreacion!="") $Logdata['ecodCreacion'] = trim($sqllogCatUsuario[0]->ecodCreacion, '"');
        if (isset($sqllogCatUsuario[0]->ecodEdicion)&&$sqllogCatUsuario[0]->ecodEdicion!="") $Logdata['ecodEdicion'] = trim($sqllogCatUsuario[0]->ecodEdicion, '"');
        if (isset($sqllogCatUsuario[0]->fhEdicion)&&$sqllogCatUsuario[0]->fhEdicion!="") $Logdata['fhEdicion'] = trim($sqllogCatUsuario[0]->fhEdicion, '"');
        $Logdata['ecodUsuario'] = $data; 
        $uuiecodUsuario = Uuid::uuid4();
        $Logdata['ecodLogUsuario'] = (isset($uuiecodUsuario)&&$uuiecodUsuario!="" ? "".(trim($uuiecodUsuario))."":   Null);
        logcatusuarios::insert($Logdata);
        return($Logdata);
    }

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
        
        $sql = catusuario::query()
        ->when(!empty($tNombre), fn($q) => $q->where('tNombre', 'like', "%$tNombre%"))
        ->orderBy($metodos->tMetodoOrdenamiento ?? 'tNombre', $metodos->orden ?? 'asc')
        ->limit($metodos->eNumeroRegistros ?? 10)
        ->get();
        
        $arrsql = [];

        if($sql->count() > 0){
            foreach ($sql as $key => $v){
                    $arrsql[]=array(
                        'ecodUsuario' => $v->ecodUsuario,
                        'Nombre'=> $v->tNombre . ' ' . $v->tApellido,
                    );
            } 
        }

        $jsonData = json_encode($arrsql);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json( $returResponse); 
    }
}
