<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Catalogo\productos;

Route::post('catalogo/productos', [productos::class,'getRegistro'])->middleware(['sesionactiva','Validadpermisos']);
Route::post('catalogo/productos/detalles', [productos::class,'getDetalles'])->middleware(['sesionactiva']);
Route::post('catalogo/productos/registrar', [productos::class,'postRegistro'])->middleware(['sesionactiva','Validadpermisos']); 
Route::post('catalogo/productos/eliminar', [productos::class,'postEliminar'])->middleware('sesionactiva','Validadpermisos'); 
