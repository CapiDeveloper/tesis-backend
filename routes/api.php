<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\VerificacionController;
use App\Http\Controllers\OlvidarClaveController;
use App\Http\Controllers\RestablecerClaveController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\LugarTuristicoController;

Route::middleware(['auth:sanctum, verified'])->group(function(){
    Route::get('/usuario', function (Request $request){
        return $request->user();
    });
    Route::post('/cerrar-sesion', [AutenticacionController::class,'cerrarSesion']);
    Route::get('/obtener-usuarios', [UserController::class,'obtenerLugares']);

    //  CRUD Tipo de lugar turistico
    Route::apiResource('/tipo-lugar', TipoController::class);

    //  CRUD Lugar Turistico
    Route::apiResource('/lugar-turistico', LugarTuristicoController::class);

});

// Control de cuentas
Route::post('/iniciar-sesion', [AutenticacionController::class,'iniciarSesion']);
Route::post('/registrar-usuario', [UserController::class,'registro']);
Route::post('/verificar-email/{token}', [VerificacionController::class, 'verificarEmail']);
Route::post('/olvidar-clave', [OlvidarClaveController::class, 'enviarEmail']);
Route::post('/restablecer-clave', [RestablecerClaveController::class, 'restablecer']);