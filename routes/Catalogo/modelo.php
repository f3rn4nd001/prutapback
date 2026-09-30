<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Catalogo\modelo;

Route::post('catalogo/modelo/comprementos', [modelo::class,'getComprementos'])->middleware(['sesionactiva']);
