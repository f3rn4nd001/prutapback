<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\seg\encriptar;
use App\Http\Controllers\seg\objetArray;
use App\Models\catproductos;
use App\Models\catestatus;
use App\Models\catusuario;
use App\Models\catmarca;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use App\Models\relusuariocorreo;
use App\Models\logcatproducro;

class productos extends Controller
{
    public function getRegistro(Request $request){
        //pide los registras de productos filtrando por nombre, nPrecioy estatus
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
        $sql = catproductos::query()
        ->when(!empty($ecodProductos), fn($q) => $q->where('ecodProductos', 'like', "%$ecodProductos%"))
        ->when(!empty($tNombre), fn($q) => $q->where('tNombre', 'like', "%$tNombre%"))
        ->when(!empty($nPrecio), fn($q) => $q->whereBetween('nPrecio', [$nPrecio - 1, $nPrecio + 1]))
        ->when(!empty($ecodEstatus), fn($q) => $q->where('ecodEstatus', 'like', "%$ecodEstatus%"))
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
                'ecodProductos' => $v->ecodProductos,
                'nPrecio' => $v->nPrecio,
                'tNombre'=> $v->tNombre,
                'fhCreacion' => $v->fhCreacion->format('d/m/Y H:i'),
                'estatus'=> catestatus::where('ecodEstatus',$v->ecodEstatus)->value('tNombre')           
            );
        } 
        $jsonData = json_encode($arrsql);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json( $returResponse); 
    }

    public function getDetalles(Request $request){
        //muestra los detalles del guardado de un producto de la tabla catproductos
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = (isset($jsonX->data)&&$jsonX->data!="" ? "".(trim($jsonX->data))."":   Null);
        
        $sqlProducto = catproductos::where('ecodProductos',$json)->get(); 
        foreach ($sqlProducto as $key => $v){
            $arrsqlProducto[]=array(
                'ecodProductos' => $v->ecodProductos,
                'tNombre' => $v->tNombre,
                'ecodMarca' => $v->ecodMarca,
                'nPrecio' => $v->nPrecio,
                'ecodEstatus' => $v->ecodEstatus,
                'ecodCreacion' => $v->ecodCreacion,
                'fhCreacion' => $v->fhCreacion->format('d/m/Y H:i'),
                'Marca' => catmarca::where('ecodMarca',$v->ecodMarca)->value('tNombre'),
                'Estatus' => catestatus::where('ecodEstatus',$v->ecodEstatus)->value('tNombre'),
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

        $data = ['sqlProducto'=>(isset($arrsqlProducto[0]) ? $arrsqlProducto[0] : "")];
        $jsonData = json_encode($data);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse);
    }

    public function postRegistro(Request $request){
        //Guardar informacion del usuario
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = isset($jsonX->Producto) ? $jsonX->Producto : [];
        $jsonH =json_decode($encriptar->shiftText($request['headers'], -23));
        $jsonarrCorreo  = isset($json->arrCorreo) ? $json->arrCorreo : [];
        $data = [];
      
        if (isset($json->tNombre)) $data['tNombre'] = trim($json->tNombre, '');
        if (isset($json->nPrecio)) $data['nPrecio'] = trim($json->nPrecio, '');
        if (isset($json->Marca->ecodMarca)) $data['ecodMarca'] = trim($json->Marca->ecodMarca, '');
        $ecodProductos = (isset($json->ecodProductos)&&$json->ecodProductos!="" ? "".(trim($json->ecodProductos))."":   Null);
        $ecodCorreo = trim($jsonH->ecodCorreo, '"');
        //si el producto no esta registrado(ecod) se crea un id nuevo, revisa que no se tepita un producto
        if ($ecodProductos == Null) {
            $uuiecod = Uuid::uuid4();
            $data['ecodProductos'] = (isset($uuiecod)&&$uuiecod!="" ? "".(trim($uuiecod))."":   Null);
            $data['fhCreacion'] = Carbon::now();
            $data['ecodEstatus'] = "2660376e-dbf8-44c1-b69f-b2554e3e5d4c";
            $data['ecodCreacion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
            $existeCorreo = catproductos::where('tNombre', $data['tNombre'])->exists();
            if (!$existeCorreo) {
                catproductos::insert($data);
                $responseUsuario = $data['ecodProductos'];
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
            $sqlcaproducto = catproductos::where('tNombre', $data['tNombre'])->get();
            if ($sqlcaproducto->isNotEmpty()) {
                if ($sqlcaproducto[0]->ecodProductos == $ecodProductos) {
                    $this->logs($ecodProductos);
                    $data['fhEdicion'] = Carbon::now();
                    $data['ecodEstatus'] = (isset($json->ecodEstatus)&&$json->ecodEstatus!="" ? "".(trim($json->ecodEstatus))."":   Null);
                    $data['ecodEdicion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
                    catproductos::where('ecodProductos',$ecodProductos)->update($data);
                    $responseUsuario=$ecodProductos;
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
                $this->logs($ecodProductos);
                $data['fhEdicion'] = Carbon::now();
                $data['ecodEstatus'] = (isset($json->ecodEstatus)&&$json->ecodEstatus!="" ? "".(trim($json->ecodEstatus))."":   Null);
                $data['ecodEdicion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
                catproductos::where('ecodProductos',$ecodProductos)->update($data);
                $responseUsuario=$ecodProductos;
            }
        }

        $jsonData = json_encode($responseUsuario);
        $returResponse2 =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse2);
    }

    // logs -> insert de logs usuarios
    public function logs($data) {
        //se pide los datos del usuario y se guarda en el log

        $Logdata = [];
        $sqllog = catproductos::where('ecodProductos',$data)->get();
       
        if (isset($sqllog[0]->tNombre)&&$sqllog[0]->tNombre!="") $Logdata['tNombre'] = trim($sqllog[0]->tNombre, '');
        if (isset($sqllog[0]->nPrecio)&&$sqllog[0]->nPrecio!="") $Logdata['nPrecio'] = trim($sqllog[0]->nPrecio, '');
        if (isset($sqllog[0]->ecodMarca)&&$sqllog[0]->ecodMarca!="") $Logdata['ecodMarca'] = trim($sqllog[0]->ecodMarca, '');
        if (isset($sqllog[0]->fhCreacion)&&$sqllog[0]->fhCreacion!="") $Logdata['fhCreacion'] = trim($sqllog[0]->fhCreacion, '"');
        if (isset($sqllog[0]->ecodCreacion)&&$sqllog[0]->ecodCreacion!="") $Logdata['ecodCreacion'] = trim($sqllog[0]->ecodCreacion, '');
        if (isset($sqllog[0]->ecodEdicion)&&$sqllog[0]->ecodEdicion!="") $Logdata['ecodEdicion'] = trim($sqllog[0]->ecodEdicion, '');
        if (isset($sqllog[0]->fhEdicion)&&$sqllog[0]->fhEdicion!="") $Logdata['fhEdicion'] = trim($sqllog[0]->fhEdicion, '');
        
        $Logdata['ecodProductos'] = $data; 
        $uuiecodUsuario = Uuid::uuid4();
        $Logdata['ecodLogProducto'] = (isset($uuiecodUsuario)&&$uuiecodUsuario!="" ? "".(trim($uuiecodUsuario))."":   Null);
        logcatproducro::insert($Logdata);
        return($Logdata);
    }

    public function postEliminar(Request $request){
        //Crea un log. Elimina el producto de catproductos
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = isset($jsonX->formGroup) ? $jsonX->formGroup : [];
        $jsonH =json_decode($encriptar->shiftText($request['headers'], -23));

        $ecod = (isset($jsonX->ecod)&&$jsonX->ecod!="" ? "".(trim($jsonX->ecod))."":   Null);
        $ecodCorreo = trim($jsonH->ecodCorreo, '"');
        $sqllog = $this->logs($ecod);
        
        $sqllog['ecodEdicion'] = relusuariocorreo::where('ecodCorreo',$ecodCorreo)->value('ecodUsuario'); 
        $sqllog['$tMotivoEliminacon'] = (isset($json->mEliminacion)&&$json->mEliminacion!="" ? "".(trim($json->mEliminacion))."":   Null);
        $sqllog['ecodEstatus'] = "fa6cc9a2-f221-4e27-b575-1fac2698d27a";
        $loguuid = Uuid::uuid4();
        $sqllog['ecodLogUsuario'] = (isset($loguuid)&&$loguuid!="" ? "".(trim($loguuid))."":   Null);
        logcatproducro::insert($sqllog);
        catproductos::where('ecodProductos',$ecod)->delete();
        
        $data = [
            'mensaje'=>"Se elimino los datos relacionada a $ecod",
        ];
        
        $jsonData = json_encode($data);
        $returResponse2 =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse2,202);
    }
}
