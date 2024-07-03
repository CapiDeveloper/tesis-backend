<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LugarTuristicoRequest;
use App\Models\LugarTuristico;
use App\Models\EventLog;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;

class LugarTuristicoController extends Controller
{

    public function index()
    {

        $user = Auth::user();

        if($user){
            if($user->rol == 0){
                
                $lugaresTuristicos = LugarTuristico::all();
            
                return [
                    'valido'=>true,
                    'lugaresTuristicos'=> $lugaresTuristicos
                ];
            }else if($user->rol == 1){

                $lugares = LugarTuristico::where('user_id',$user->id)->get();
                if($lugares){


                    $evento =  EventLog::create([
                        'user_id' => Auth::id(),
                        'event_type' => 'view_place',
                        'details' => json_encode(['place_id' => $id])
                    ]);

                    if($evento){
                        return [
                            'valido'=>true,
                            'lugaresTuristicos'=> $lugares
                        ];
                    }else{
                        return [
                            'valido'=>false,
                        ];
                    }
                }else{
                    return [
                        'valido'=>false
                    ];    
                }
            }
        }else{
            return [
                'valido'=>false,
            ]; 
        }
    }

    public function store(LugarTuristicoRequest $request)
{
    $user = Auth::user();
    
    if($user->rol == 0 || $user->rol == 1){
        $data = $request->validated();
        $imagenTemporal = $_FILES['logo']['tmp_name'];
        $nombreOriginal = $_FILES['logo']['name'];

        // Procesar y guardar la imagen
        $nombreImg = ImageService::procesarYGuardar($imagenTemporal, $nombreOriginal,300,300);
    

        $lugar = LugarTuristico::create([
            'nombre' => $data['nombre'],
            'url' => LugarTuristico::generateUrl($data['nombre']),
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

        $evento =  EventLog::create([
            'user_id' => Auth::id(),
            'event_type' => 'crear-lugar',
            'details' => json_encode(['place_id' => $lugar->id])
        ]);

        if($evento){
            return [
                'valido'=> true,
                'image'=>$lugar
            ];
        }else{
            return [
                'valido'=>false,
            ];    
        }
    }else{
        return [
            'valido'=>false,
        ];    
    }
}

    public function show($id)
    {

        $user = Auth::user();
        $lugarTuristico = LugarTuristico::findOrFail($id);


        if($user->rol == 0 || $user->rol == 1){

            if($lugarTuristico->user_id == $user->id || $user->rol == 0){
                return [
                    'valido' => true,
                    'lugarTuristico' => $lugarTuristico
                ];
            }else{
                return [
                    'valido' => false
                ];
            }
        }else{
            return [
                'valido'=>false,
            ];    
        }
    }

    public function update(LugarTuristicoRequest $request, $id)
    {

        $user = Auth::user();
        if($user->rol == 0){
            $data = $request->validated();
            $lugarTuristico = LugarTuristico::findOrFail($id);
            $lugarTuristico->url = LugarTuristico::generateUrl($data['nombre']);
            $lugarTuristico->update($data);

            $evento =  EventLog::create([
                'user_id' => Auth::id(),
                'event_type' => 'actualizar-lugar',
                'details' => json_encode(['place_id' => $lugarTuristico->id])
            ]);
    
            if($evento){
                return [
                    'valido' => true,
                ];
            }else{
                return [
                    'valido'=>false,
                ];
            }
        }else{
            return [
                'valido'=>false,
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

                $evento =  EventLog::create([
                    'user_id' => Auth::id(),
                    'event_type' => 'eliminar-lugar',
                    'details' => json_encode(['place_id' => $id])
                ]);
        
                if($evento){
                    return [
                        'valido'=>$id
                    ];
                }else{
                    return [
                        'valido'=>false
                    ];
                }
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
