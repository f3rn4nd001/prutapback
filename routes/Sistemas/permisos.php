<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Sistemas\permisos;

Route::post('sistemas/permisos/detalles', [permisos::class,'getDetalles'])->middleware('sesionactiva'); 
Route::post('sistemas/permisos/registrar', [permisos::class,'postRegistro'])->middleware('sesionactiva','Validadpermisos'); 
