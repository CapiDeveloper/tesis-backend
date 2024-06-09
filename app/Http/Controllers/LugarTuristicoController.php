<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LugarTuristicoRequest;
use App\Models\LugarTuristico;
use App\Services\ImageService;

class LugarTuristicoController extends Controller
{

    public function index()
    {
        //
    }

    public function store(Request $request)
{

    \Log::info('Datos recibidos:', ['data' => $request->all()]);
        \Log::info('Archivos recibidos:', ['files' => $request->file()]);
    return [
        'val'=>$request->all()
    ];

    // $data = $request->validated();

    // // Verificar si se ha cargado un archivo
    // if ($request->hasFile('logo')) {
    //     // Procesar y guardar la imagen
    //     $imagePath = ImageService::procesarYGuardar($request->file('logo'));

    //     $lugar = LugarTuristico::create([
    //          'nombre' => $data['nombre'],
    //          'descripcion' => $data['descripcion'],
    //          'direccion' => $data['direccion'],
    //          'longitud' => $data['longitud'],
    //          'latitud' => $data['latitud'],
    //          'contacto' => $data['contacto'],
    //          'logo' => $imagePath,
    //          'mapa' => 'mapa.png',
    //          'user_id' => $data['user_id'],
    //          'tipo_id' => $data['tipo_id'],
    //     ]);

    //     return response()->json(['message' => 'Lugar turístico creado correctamente'], 201);
    // } else {
    //     return response()->json(['error' => 'No se ha seleccionado ningún archivo'], 400);
    // }
}

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
