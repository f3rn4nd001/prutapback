<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\loginController;


Route::post('Login', [loginController::class,'posLogin']);
Route::post('Login/postValidadContrasena', [loginController::class,'postValidadContrasena'])->middleware('sesionactiva');
Route::post('Login/recucontra', [loginController::class,'posLoginRecuperarContrasena']);
