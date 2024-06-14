<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LugarTuristicoRequest;
use App\Models\LugarTuristico;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;

class LugarTuristicoController extends Controller
{

    public function index()
    {

        $user = Auth::user();

        if($user->rol == 0){
            $lugaresTuristicos = LugarTuristico::all();
        
            return [
                'valido'=>true,
                'lugaresTuristicos'=> $lugaresTuristicos
            ];
        }else{
            return [
                'valido'=>true,
            ];    
        }
    }

    public function store(LugarTuristicoRequest $request)
{
    $user = Auth::user();
    
    if($user->rol == 0){
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
    }else{
        return [
            'valido'=>true,
        ];    
    }
}

    public function show($id)
    {

        $user = Auth::user();
        if($user->rol == 0){
            $lugarTuristico = LugarTuristico::findOrFail($id);

            return [
                'valido' => true,
                'lugarTuristico' => $lugarTuristico
            ];
        }else{
            return [
                'valido'=>true,
            ];    
        }
    }

    public function update(LugarTuristicoRequest $request, $id)
    {

        $user = Auth::user();
        if($user->rol == 0){
            $data = $request->validated();
            $lugarTuristico = LugarTuristico::findOrFail($id);

            $lugarTuristico->update($data);

            return [
                'valido' => true,
            ];
        }else{
            return [
                'valido'=>true,
            ];    
        }
    }

    public function destroy($id)
    {

        $user = Auth::user();
        if($user->rol == 0){
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
        }else{
            return [
                'valido'=>true,
            ];    
        }
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
