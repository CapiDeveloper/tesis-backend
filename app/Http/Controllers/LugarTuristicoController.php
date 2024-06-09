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
        $lugaresTuristicos = LugarTuristico::all();
        
        return [
            'valido'=>true,
            'lugaresTuristicos'=> $lugaresTuristicos
        ];
    }

    public function store(LugarTuristicoRequest $request)
{

        $data = $request->validated();
        $imagenTemporal = $_FILES['logo']['tmp_name'];
        $nombreOriginal = $_FILES['logo']['name'];

        // Procesar y guardar la imagen
        $nombreImg = ImageService::procesarYGuardar($imagenTemporal, $nombreOriginal,350,200);
    

        $lugar = LugarTuristico::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'direccion' => $data['direccion'],
            'longitud' => $data['longitud'],
            'latitud' => $data['latitud'],
            'contacto' => $data['contacto'],
            'logo' => $nombreImg,
            'mapa' => 'mapa.png',
            'user_id' => $data['user_id'],
            'tipo_id' => $data['tipo_id'],
        ]);

    return [
        'valido'=> true,
        'image'=>$lugar
    ];
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
