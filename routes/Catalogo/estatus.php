<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Catalogo\estatus;

Route::post('catalogo/estatus/comprementos', [estatus::class,'getcompremento'])->middleware(['sesionactiva']);

