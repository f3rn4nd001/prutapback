<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use App\Http\Controllers\seg\encriptar;
use App\Models\Bitcorreo;
use App\Models\relusuariomenusubmenucontroller;

class Validadpermisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $encriptar = new encriptar();

        $reqs=$request->all();
        foreach ($reqs as $key => $value) {
            if(array_key_exists($key, $reqs) ){
				if ($value != ''){
					${$key} =$value ;
                  	}
			}
        }
        
        $urls =json_decode($encriptar->shiftText($request['datos'], -23));
        $descompriheader =json_decode($encriptar->shiftText($request['headers'], -23));
        $Url = (isset($urls->urls) && $urls->urls != "" ? "/" . (trim($urls->urls)) . "" : "");
        $ecodCorreo = trim($descompriheader->ecodCorreo, '"');
        $tToken = trim($descompriheader->token, '"');

        $sqlEcodCorreo = bitcorreo::where('ecodCorreo', $ecodCorreo)->where('tToken', $tToken)->get();
        if($sqlEcodCorreo->isNotEmpty()){
            $sqlEcodUsuario = DB::connection('mongodb')->table('relusuariocorreo')->where('ecodCorreo', $ecodCorreo)->get();
            $ecodUsuario = (isset($sqlEcodUsuario[0]->ecodUsuario) && $sqlEcodUsuario[0]->ecodUsuario != "" ? "" . (trim($sqlEcodUsuario[0]->ecodUsuario)) . "" : "");             
            $tokencontroll = (isset($request->tokencontroll) && $request->tokencontroll != "" ? "" . (trim($request->tokencontroll)) . "" : "");             
            $sqlMenu = relusuariomenusubmenucontroller::raw(function ($collection) use ($ecodUsuario, $tokencontroll, $Url) {
                return $collection->aggregate([
                    // JOIN con catsubmenu
                    [
                        '$lookup' => [
                            'from' => 'catsubmenu',
                            'localField' => 'ecodSubmenu',
                            'foreignField' => 'ecodSubmenu',
                            'as' => 'submenu'
                        ]
                    ],
                    // JOIN con catcontroller
                    [
                        '$lookup' => [
                            'from' => 'catcontroller',
                            'localField' => 'ecodController',
                            'foreignField' => 'ecodControler',
                            'as' => 'controller'
                        ]
                    ],
                    // Descomponer arrays para poder filtrar internamente
                    [ '$unwind' => [ 'path' => '$submenu', 'preserveNullAndEmptyArrays' => true ] ],
                    [ '$unwind' => [ 'path' => '$controller', 'preserveNullAndEmptyArrays' => true ] ],
                    
                    // Aplicar filtros
                    [
                        '$match' => [
                            '$or' => [
                                [
                                    '$and' => [
                                        ['ecodUsuario' => $ecodUsuario],
                                        ['tToken' => $tokencontroll],
                                        ['submenu.tUrl' => $Url]
                                    ]
                                ],
                                [
                                    '$and' => [
                                        ['ecodUsuario' => $ecodUsuario],
                                        ['tToken' => $tokencontroll],
                                        ['controller.tUrl' => $Url]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    // Contar resultados
                    [
                        '$count' => 'dl'
                    ]
                ]);
            });
            if ($sqlMenu[0]->dl >= 1) {
                return $next($request);
            }  
            else {
                $data = [
                    'mensaje'=>"Usuario invalido, No cuenta con los permisos",
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
