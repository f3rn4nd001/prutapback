<?php

namespace App\Http\Controllers\Transportista\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\seg\encriptar;
use Illuminate\Support\Facades\DB;
use App\Models\Transportista\relusuariomenusubmenucontrollertransportista;
use App\Models\Transportista\relusuariocorreotransportista;
use App\Models\Transportista\bitcorreotransportista;
use Tymon\JWTAuth\Facades\JWTAuth;
use Ramsey\Uuid\Uuid;

class permisos extends Controller
{
    public function getDetalles(Request $request){
         $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $json = (isset($jsonX->data)&&$jsonX->data!="" ? "".(trim($jsonX->data))."":   Null);
        
        $selectRelUsuarioPermisos="SELECT rmsc.ecodMenu , rmsc.ecodSubmenu, rmsc.ecodController, cm.tNombre AS tNombreMenu, cs.tNombre AS tNombreSubMenu, cc.tNombre AS tNombreController  FROM relusuariomenusubmenucontroller AS rmsc 	
        LEFT JOIN catmenu cm ON cm.ecodMenu = rmsc.ecodMenu
        LEFT JOIN catsubmenu cs ON cs.ecodSubmenu = rmsc.ecodSubmenu
        LEFT JOIN catcontroller cc ON cc.ecodControler= rmsc.ecodController
        WHERE rmsc.ecodUsuario = ? ORDER BY cm.tNombre, cs.tNombre ASC";
        $sqlRelUsuarioPermisos = DB::connection('mysqlTransportista')->select($selectRelUsuarioPermisos,[$json]);
        $jsonData = json_encode($sqlRelUsuarioPermisos);
        $returResponse =$encriptar->shiftText($jsonData, 23);        
        return response()->json($returResponse);
    }

    public function postRegistro(Request $request){
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $jsonH =json_decode($encriptar->shiftText($request['headers'], -23));
        $ecod = (isset($jsonX->ecodUsuario)&&$jsonX->ecodUsuario!="" ? "".(trim($jsonX->ecodUsuario))."": NULL);
        $ecodCorreoEditor = trim($jsonH->ecodCorreo, '"');
        try{
            DB::beginTransaction();
            //Eliminar todo dato relacionado a usauario a editar
            relusuariomenusubmenucontrollertransportista::where('ecodUsuario',$ecod)->delete();
            //usuario a editar
            $ecodCorreoUsuario = relusuariocorreotransportista::where('ecodUsuario',$ecod)->value('ecodCorreo');       
            $user=bitcorreotransportista::all()->where('ecodCorreo', $ecodCorreoUsuario)->first();
            $json = isset($jsonX->Rutas) ? $jsonX->Rutas : [];
            if (count($json) > 0) {
                foreach ($json as $key => $value1) {
                    $ecodMenu = (isset($value1->ecodMenu)&&$value1->ecodMenu!="" ? "".(trim($value1->ecodMenu))."": NULL);
                    $ecodSubmenu = (isset($value1->ecodSubmenu)&&$value1->ecodSubmenu!="" ? "".(trim($value1->ecodSubmenu))."": NULL);
                    $ecodController = (isset($value1->ecodController)&&$value1->ecodController!="" ? "".(trim($value1->ecodController))."": NULL);      
                    $uuieControlador = Uuid::uuid4();
                    $uuidControlador2 = (isset($uuieControlador)&&$uuieControlador!="" ? "".(trim($uuieControlador))."": NULL);                    
                    $token=JWTAuth::fromUser($user);
                    $tokenv = (isset($token) && $token != "" ? "" . (trim($token)) . "" : "");             
                    $inserRelUsuarioMenuSubContro=" CALL `stpInsertarRelUsuarioMenuSubContro`(?,?,?,?,?,?)";
                    $responseRelMenuSubContro = DB::connection('mysqlTransportista')->select($inserRelUsuarioMenuSubContro,[$uuidControlador2,$ecod,$ecodMenu,$ecodSubmenu,$ecodController,$tokenv]);
                }
            }
            DB::commit();
            $jsonData = json_encode($ecod);
            $returResponse2 =$encriptar->shiftText($jsonData, 23);
            return response()->json($returResponse2);
        }
        catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['error' => 'Error inesperado', 'detalles' => $e->getMessage()], 500);
        }
        
    }
}
