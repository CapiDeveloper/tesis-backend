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
use App\Http\Controllers\LogoImagenController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\HorarioController;

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    
    // Usuarios
    Route::get('/usuario', function (Request $request){
        return $request->user();
    });
    Route::post('/cerrar-sesion', [AutenticacionController::class,'cerrarSesion']);
    Route::get('/obtener-usuarios', [UserController::class,'obtenerLugares']);
    // Subir imagen perfil
    Route::post('/subir-imagen-perfil', [UserController::class,'subirImagenPerfil']);

    //  CRUD Tipo de lugar turistico
    Route::apiResource('/tipo-lugar', TipoController::class);

    //  CRUD Lugar Turistico (pendiente)
    Route::apiResource('/lugar-turistico', LugarTuristicoController::class);
    Route::post('/actualizar-imagen-logo', [LogoImagenController::class,'actualizarLogo']);

    // CRUD imagenes
    Route::apiResource('/imagenes-lugar-turistico', FotoController::class);

    // CRUD imagenes
    Route::apiResource('/horario-lugar-turistico', HorarioController::class);
    
});

// Control de cuentas
Route::post('/iniciar-sesion', [AutenticacionController::class,'iniciarSesion']);
Route::post('/registrar-usuario', [UserController::class,'registro']);
Route::post('/verificar-email/{token}', [VerificacionController::class, 'verificarEmail']);
Route::post('/olvidar-clave', [OlvidarClaveController::class, 'enviarEmail']);
Route::post('/restablecer-clave', [RestablecerClaveController::class, 'restablecer']);