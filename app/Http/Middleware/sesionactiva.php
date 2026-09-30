<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use App\Http\Controllers\seg\encriptar;
use App\Models\Bitcorreo;
use App\Models\catestatus;
use App\Models\catusuario;

class sesionactiva
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $encriptar = new encriptar();
        $datos =json_decode($encriptar->shiftText($request['headers'], -23));
        $ecodCorreo = trim($datos->ecodCorreo, '"');
        $tToken = trim($datos->token, '"');

        $sqlEcodCorreo = bitcorreo::where('ecodCorreo', $ecodCorreo)->where('tToken', $tToken)->get();
        if($sqlEcodCorreo->isNotEmpty()){
            
            $sqlEcodUsuario = DB::connection('mongodb')->table('relusuariocorreo')->where('ecodCorreo', $ecodCorreo)->get();
            $ecodUsuario = (isset($sqlEcodUsuario[0]->ecodUsuario) && $sqlEcodUsuario[0]->ecodUsuario != "" ? "" . (trim($sqlEcodUsuario[0]->ecodUsuario)) . "" : "");             

            $Estatus= catestatus::where('ecodEstatus',catusuario::where('ecodUsuario',$ecodUsuario)->value('ecodEstatus'))->value('tNombre');            
            if ($Estatus == "Activo") {
                return $next($request);
            }
            else {
                $data = [
                    'mensaje'=>"Usuario invalido, Inicie sesion nuevamente",
                ];
                $jsonData = json_encode($data);
                $returResponse =$encriptar->shiftText($jsonData, 23);
                return response()->json($returResponse,401); 
            }
        }
        else{
            $data = [
                'mensaje'=>"Token invalido, Inicie sesion nuevamente",
            ];
            $jsonData = json_encode($data);
            $returResponse =$encriptar->shiftText($jsonData, 23);
            return response()->json($returResponse,401); 
        }
    }
}
