<?php

namespace App\Http\Controllers\Catalogo;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\catestatus;
use App\Http\Controllers\seg\encriptar;
use App\Http\Controllers\seg\objetArray;

class Estatus extends Controller
{    
    public function getcompremento(Request $request) {
        $sqlact=catestatus::all('ecodEstatus','tNombre'); 
        $encriptar = new encriptar();
        $returResponse = $encriptar->shiftText($sqlact, 23);
        return response()->json($returResponse);
    }
}
