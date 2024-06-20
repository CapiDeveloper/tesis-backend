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
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoImagenController;
use App\Http\Controllers\DisponibilidadProductoController;
use App\Http\Controllers\InformacionLugarController;
use App\Http\Controllers\ComentarioController;


Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    
    // Usuarios
    Route::get('/usuario', function (Request $request){
        return $request->user();
    });
    Route::post('/cerrar-sesion', [AutenticacionController::class,'cerrarSesion']);
    Route::get('/obtener-usuarios', [UserController::class,'obtenerUsuarios']);
    Route::post('/actualizar-usuario', [UserController::class,'actualizar']);

    // Subir imagen perfil
    Route::post('/subir-imagen-perfil', [UserController::class,'subirImagenPerfil']);

    //  CRUD Tipo de lugar turistico
    Route::apiResource('/tipo-lugar', TipoController::class);

    //  CRUD Lugar Turistico (pendiente - editar usuario)
    Route::apiResource('/lugar-turistico', LugarTuristicoController::class);
    Route::post('/actualizar-imagen-logo', [LogoImagenController::class,'actualizarLogo']);

    // CRUD imagenes
    Route::apiResource('/imagenes-lugar-turistico', FotoController::class);

    // CRUD Horarios
    Route::apiResource('/horario-lugar-turistico', HorarioController::class);

    // CRUD Servicios
    Route::apiResource('/servicio-lugar-turistico', ServicioController::class);

    // CRUD Ofertas
    Route::apiResource('/oferta-lugar-turistico', OfertaController::class);

    // CRUD Categoria productos
    Route::apiResource('/categoria-lugar-turistico', CategoriaController::class);

    // CRUD Productos
    Route::apiResource('/producto-lugar-turistico', ProductoController::class);
    Route::post('/actualizar-imagen-producto', [ProductoImagenController::class,'actualizarimagen']);
    Route::post('/actualizar-disponibilidad-producto', [DisponibilidadProductoController::class,'actualizarDisponibilidad']);

    // CRUD Comentarios
    Route::post('/comentario-lugar-turistico', [ComentarioController::class,'store']);
    Route::delete('/comentario-lugar-turistico-eliminar', [ComentarioController::class,'delete']);
    Route::put('/comentario-lugar-turistico-actualizar/{id}', [ComentarioController::class,'update']);
    Route::get('/comentarios-usuario', [ComentarioController::class, 'obtenerPorUsuario']);
    
});

// Control de cuentas
Route::post('/iniciar-sesion', [AutenticacionController::class,'iniciarSesion']);
Route::post('/registrar-usuario', [UserController::class,'registro']);
Route::post('/verificar-email/{token}', [VerificacionController::class, 'verificarEmail']);
Route::post('/olvidar-clave', [OlvidarClaveController::class, 'enviarEmail']);
Route::post('/restablecer-clave', [RestablecerClaveController::class, 'restablecer']);

// Cuentas de popos
Route::get('/info-lugar', [InformacionLugarController::class, 'obtenerLugar']);
Route::get('/info-horario', [InformacionLugarController::class, 'obtenerHorario']);
Route::get('/info-producto', [InformacionLugarController::class, 'obtenerProducto']);
Route::get('/info-imagen', [InformacionLugarController::class, 'obtenerImagen']);
Route::get('/info-servicio', [InformacionLugarController::class, 'obtenerServicio']);
Route::get('/lugares-recomendar-sidebar', [InformacionLugarController::class, 'obtenerLugaresSidebar']);

Route::get('/lugares-caterigoria', [InformacionLugarController::class, 'obtenerLugaresCategoria']);
Route::get('/lugares-filtro', [InformacionLugarController::class, 'obtenerLugaresFiltro']);
Route::get('/categorias-lugares', [InformacionLugarController::class, 'obtenerCategorias']);

Route::get('/info-comentario', [ComentarioController::class, 'index']);