<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Catalogo\tipousuario;

Route::post('catalogo/tipousuario/comprementos', [tipousuario::class,'getComprementos'])->middleware(['sesionactiva']);
Route::post('catalogo/perfiles', [tipousuario::class,'getRegistro'])->middleware(['sesionactiva','Validadpermisos']);
Route::post('catalogo/perfiles/detalles', [tipousuario::class,'getDetalles'])->middleware(['sesionactiva']);
Route::post('catalogo/perfiles/registrar', [tipousuario::class,'postRegistro'])->middleware(['sesionactiva','Validadpermisos']); 
Route::post('catalogo/perfiles/eliminar', [tipousuario::class,'postEliminar'])->middleware('sesionactiva','Validadpermisos'); 
