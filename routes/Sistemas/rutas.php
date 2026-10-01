<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Sistemas\relrutas;

//Route::post('sistemas/rutas', [relrutas::class,'getRegistro'])->middleware(['bloqueado','sesionactiva','Validadpermisos','administrador']);
Route::post('sistemas/rutas/detalles', [relrutas::class,'getRegistro'])->middleware(); 