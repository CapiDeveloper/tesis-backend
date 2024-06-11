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
        $nombreImg = ImageService::procesarYGuardar($imagenTemporal, $nombreOriginal,200,200);
    

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
         // Buscar el lugar turístico por su ID
        $lugarTuristico = LugarTuristico::findOrFail($id);

        // Devolver la información del lugar turístico
        return [
            'valido' => true,
            'lugarTuristico' => $lugarTuristico
        ];
    }

    public function update(LugarTuristicoRequest $request, $id)
    {
        $data = $request->validated();
        $lugarTuristico = LugarTuristico::findOrFail($id);

        $lugarTuristico->update($data);

        return [
            'valido' => true,
        ];
    }

    public function destroy($id)
    {
        $tipo = LugarTuristico::findOrFail($id);
        
        // eliminar imagenes
        if($tipo->logo){
            $this->eliminarImagenesAnteriores($tipo->logo);
        }
        // Eliminar lugar turistico
        $eliminado = $tipo->delete();

        
        if($eliminado){
            return [
                'valido'=>$id
            ];
        }
        return [
            'valido'=>false
        ];
    }
    private function eliminarImagenesAnteriores($nombreImagen)
    {
        $extensiones = ['webp', 'avif'];

        foreach ($extensiones as $ext) {
            $ruta = public_path('imagenes/') . pathinfo($nombreImagen, PATHINFO_FILENAME) . '.' . $ext;
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
    }
}
