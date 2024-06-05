<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\VerificacionController;
use App\Http\Controllers\OlvidarClaveController;
use App\Http\Controllers\RestablecerClaveController;

Route::middleware(['auth:sanctum, verified'])->group(function(){
    Route::get('/usuario', function (Request $request){
        return $request->user();
    });
    Route::post('/cerrar-sesion', [AutenticacionController::class,'cerrarSesion']);
});

Route::post('/iniciar-sesion', [AutenticacionController::class,'iniciarSesion']);

Route::post('/registrar-usuario', [UserController::class,'registro']);
Route::post('/verificar-email/{token}', [VerificacionController::class, 'verificarEmail']);

Route::post('/olvidar-clave', [OlvidarClaveController::class, 'enviarEmail']);
Route::post('/restablecer-clave', [RestablecerClaveController::class, 'restablecer']);