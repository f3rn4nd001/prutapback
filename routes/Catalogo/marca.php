<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Catalogo\marca;

Route::post('catalogo/marca/comprementos', [marca::class,'getComprementos'])->middleware(['sesionactiva']);
Route::post('catalogo/relmarcamodelo/comprementos', [marca::class,'getComprementosRelMarcaModelo'])->middleware('sesionactiva'); 
