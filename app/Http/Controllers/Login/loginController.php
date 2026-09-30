<?php

namespace App\Http\Controllers\Login;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginReuest;
use App\Models\catusuario;
use App\Models\Bitcorreo;
use App\Models\catestatus;
use App\Models\catmenu;
use App\Models\caticono;
use App\Models\catsubmenu;
use App\Models\cattipousuario;
use App\Models\catcontroller;
use App\Models\relusuariomenusubmenucontroller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\seg\encriptar;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\seg\objetArray;
use Illuminate\Support\Str;

use App\Mail\NotificacionUsuario;
use Illuminate\Support\Facades\Mail;


class loginController extends Controller
{
    
    function posLogin(Request $request) {
        $encriptar = new encriptar();
        $objetArray = new objetArray();
        $dadsad = (isset($request['haders']) && $request['haders'] != "" ? "" . (trim($request['haders'])) . "" : "" );           
         if ($dadsad=="Ox_mSak@t~r}uh_GoerfQly_=EM$4iIYk#v4oFguL)TY2b0~O[") {
            $datos =json_decode($encriptar->shiftText($request['datos'], -23)) ;
            if (is_array($datos) || is_object($datos)){
                $result = array();
                foreach ($datos as $key => $value){
                    $result[$key] = $objetArray->objeto_a_array($value);
                }
                $result; 
            }
            try{
                $exito = 1;
                $Email = (isset($result['email']) && $result['email'] != "" ? "" . (trim($result['email'])) . "" : "");           
                $password = (isset($result['password']) && $result['password'] != "" ? "" . (trim($result['password'])) . "" : "");
                $sqlEcodCorreo = bitcorreo::where('tCorreo', $Email)->first();
                if($sqlEcodCorreo && Hash::check($password, $sqlEcodCorreo->tpassword)){
                    $ecodCorreo = (isset($sqlEcodCorreo->ecodCorreo) && $sqlEcodCorreo->ecodCorreo != "" ? "" . (trim($sqlEcodCorreo->ecodCorreo)) . "" : "");                                
                    $sqlEcodUsuario = DB::connection('mongodb')->table('relusuariocorreo')->where('ecodCorreo', $ecodCorreo)->get();
                    $ecodUsuario = (isset($sqlEcodUsuario[0]->ecodUsuario) && $sqlEcodUsuario[0]->ecodUsuario != "" ? "" . (trim($sqlEcodUsuario[0]->ecodUsuario)) . "" : "");             
                    $Usuario = catusuario::where('ecodUsuario', $ecodUsuario)->get();
                    $estatus = catestatus::where('ecodEstatus', $Usuario[0]->ecodEstatus)->value('tNombre');
                    $tipoUsuario = cattipousuario::where('ecodTipoUsuario', $Usuario[0]->ecodTipoUsuario)->value('tNombre');
                    if ($estatus == "Activo") {
                        $user=bitcorreo::all()->where('tCorreo', $Email)->first();
                        $token=JWTAuth::fromUser($user);
                        $tokenv   = (isset($token) && $token != "" ? "" . (trim($token)) . "" : ""); 
                        $user->tToken = $tokenv;
                        $user->save();
                        
                        $sqlMenu = relusuariomenusubmenucontroller::where('ecodUsuario', $ecodUsuario)->get();
                        foreach ($sqlMenu as $key => $v){
                            $arrsqlmenu[]=array(
                                'Menu'=> catmenu::where('ecodMenu',$v->ecodMenu)->value('tNombre'),
                                'Iconos'=> caticono::where('ecodIcono',catmenu::where('ecodMenu',$v->ecodMenu)->value('ecodIconos'))->value('tIcono'),
                                'submenu'=> catsubmenu::where('ecodSubmenu',$v->ecodSubmenu)->value('tNombre'),
                                'urlSubMenu'=> catsubmenu::where('ecodSubmenu',$v->ecodSubmenu)->value('tUrl'),
                                'Controller'=> catcontroller::where('ecodControler',$v->ecodController)->value('tNombre'),
                                'urlController'=> catcontroller::where('ecodControler',$v->ecodController)->value('tUrl'),
                                'Token'=>$v->tToken,
                                'ecod'=>$v->ecodRelusRarioMenuSubmenuController
                            );
                        } 
                        /*foreach ($sqlMenu[0]->menus as $menu ){
                            $menuNombre = catmenu::where('ecodMenu', $menu['ecodMenu'])->value('tNombre');
                            $icono = caticono::where('ecodIcono', catmenu::where('ecodMenu', $menu['ecodMenu'])->value('ecodIconos'))->value('tIcono');
                        
                            $submenus = [];
                            foreach ($menu['submenus'] as $submenu) {
                                $submenuNombre = catsubmenu::where('ecodSubmenu', $submenu['ecodSubmenu'])->value('tNombre');
                                $urlSubmenu = catsubmenu::where('ecodSubmenu', $submenu['ecodSubmenu'])->value('tUrl');
                        
                                $controllers = [];
                                foreach ($submenu['controllers'] as $controller) {
                                    $controllerNombre = catcontroller::where('ecodControler', $controller['ecodController'])->value('tNombre');
                                    $controllerUrl = catcontroller::where('ecodControler', $controller['ecodController'])->value('tUrl');
                        
                                    $controllers[] = [
                                        'nombre' => $controllerNombre,
                                        'url' => $controllerUrl,
                                        'token' => $controller['tToken'],
                                        'ecodController' => $controller['ecodController']
                                    ];
                                }
                        
                                $submenus[] = [
                                    'nombre' => $submenuNombre,
                                    'url' => $urlSubmenu,
                                    'ecodSubmenu' => $submenu['ecodSubmenu'],
                                    'controllers' => $controllers,
                                    'tToken' => $submenu['tToken'] ?? null

                                ];
                            }
                        
                            $arrsqlmenu['menus'][] = [
                                'nombre' => $menuNombre,
                                'icono' => $icono,
                                'ecodMenu' => $menu['ecodMenu'],
                                'submenus' => $submenus,
                            ];
                       
                        }*/
                        
                        
                        $exito = 0;
                    }
                    else {
                        $data = [
                            'mensaje'=>"Esta cuenta no se encuentra activa",
                        ];
                        $jsonData = json_encode($data);
                        $returResponse =$encriptar->shiftText($jsonData, 23);
                        return response()->json($returResponse,202);
                    }
                }
                else {
                    $data = [
                        'mensaje'=>"Usuario o contraseña inválida",
                    ];
                    $jsonData = json_encode($data);
                    $returResponse =$encriptar->shiftText($jsonData, 23);
                    return response()->json($returResponse,401); 
                }
            }
            catch (Exception $e) {
                DB::rollback();
                $exito = $e->getMessage();
            }
            $data = [
                'token' => $token,
                'Menu' => isset($arrsqlmenu) ? $arrsqlmenu : "",
                'ecodCorreo' => isset($sqlEcodCorreo->ecodCorreo) ? $sqlEcodCorreo->ecodCorreo : "",
                'TipoUsuario' => isset($tipoUsuario) ? $tipoUsuario : ""
            ];        
            $jsonData = json_encode($data);
            $returResponse =$encriptar->shiftText($jsonData, 23);
          
            return response()->json( $returResponse);
        }
        $data = [
            'mensaje'=>"No cuenta con los permisos",
        ];
        $jsonData = json_encode($data);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse,202);
    }  

    function posLoginRecuperarContrasena(Request $request) {  
        $encriptar = new encriptar();
        $objetArray = new objetArray();
        $dadsad = (isset($request['haders']) && $request['haders'] != "" ? "" . (trim($request['haders'])) . "" : "" );           
        if ($dadsad=="Ox_mSak@t~r}uh_GoerfQly_=EM$4iIYk#v4oFguL)TY2b0~O[") {
            $datos =json_decode($encriptar->shiftText($request['datos'], -23)) ;
            if (is_array($datos) || is_object($datos)){
                $result = array();
                foreach ($datos as $key => $value){
                    $result[$key] = $objetArray->objeto_a_array($value);
                }
                $result; 
            }
            $Email = (isset($result['email']) && $result['email'] != "" ? "" . (trim($result['email'])) . "" : "");           
            $sqlEcodCorreo = bitcorreo::where('tCorreo', $Email)->first();
               
            if (!empty($sqlEcodCorreo)) {
                $password = Str::password(12); 
                Bitcorreo::where('tCorreo',$Email)->update([
                    'tpassword' =>  bcrypt(trim($password))
                ]);
                $datos = [
                    'mensaje' => 'Tu cuenta ha sido actualizada correctamente. ',
                    'password' => $password
                ];
                Mail::to($result['email'])->send(new NotificacionUsuario($datos));
                $data = [
                    'mensaje'=>"La contraseña se envio a su correo",
                ];
                $jsonData = json_encode($data);
                $returResponse =$encriptar->shiftText($jsonData, 23);
                return response()->json($returResponse);
            }

        }
        $data = [
            'mensaje'=>"No cuenta con los permisos",
        ];
        $jsonData = json_encode($data);
        $returResponse =$encriptar->shiftText($jsonData, 23);
        return response()->json($returResponse,202);
    }

    function postValidadContrasena(Request $request){
        $encriptar = new encriptar();
        $jsonX =json_decode($encriptar->shiftText($request['datos'], -23));
        $contrasena    = (isset($jsonX->contrasena) && $jsonX->contrasena != "" ? "" . (trim($jsonX->contrasena)) . "" : "");           
        $ecodCorreo = trim($jsonX->ecodCorreo, '"');
        if (preg_match('/^[a-zA-Z0-9.,"]+$/u', $jsonX->contrasena) == 1) {
            $bitCorreo = bitcorreo::where('ecodCorreo', $ecodCorreo)->first();
            $sqlEcodCorreo = ($bitCorreo && Hash::check($contrasena, $bitCorreo->tpassword)) ? 1 : 0;
            $jsonData = json_encode($sqlEcodCorreo);
            $returResponse =$encriptar->shiftText($jsonData, 23);              
            return response()->json( $returResponse);          
        }
        else { 
            $data = [
                'mensaje'=>"No dijite caracteres especiales ni espacios",
            ];
            $jsonData = json_encode($data);
            $returResponse =$encriptar->shiftText($jsonData, 23);
            return response()->json($returResponse,401); 
        }
    }
}
