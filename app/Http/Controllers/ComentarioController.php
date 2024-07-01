<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ComentarioRequest;
use App\Models\Comentario;
use App\Models\LugarTuristico;
use App\Models\EventLog;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ComentarioResource;

class ComentarioController extends Controller
{
    public function store(ComentarioRequest $request){
        $data = $request->validated();
        $autenticado = Auth::user();

        if($data['user_id'] == $autenticado->id){

            $comentario = Comentario::create([
                'comentario' => $data['comentario'],
                'valoracion' => $data['valoracion'],
                'lugar_turistico_id' => $data['lugar_turistico_id'],
                'user_id' => $data['user_id'],
            ]);

            if($comentario){
                $comentario->load('user');

                $evento =  EventLog::create([
                    'user_id' => Auth::id(),
                    'event_type' => 'crear-comentario',
                    'details' => json_encode(['place_id' => $comentario->id])
                ]);

                if($evento){
                    return [
                        'valido'=>true,
                        'comentario'=> new ComentarioResource($comentario)
                    ];
                }else{
                    return [
                        'valido'=>false
                    ];
                }
            }else{
                return [
                    'valido'=>false
                ];
            }
        }else{
            return [
                'valido'=>false
            ];
        }
    }

    public function update(ComentarioRequest $request, $id){
        $data = $request->validated();
        $autenticado = Auth::user();

        if($data['user_id'] == $autenticado->id){

            $comentario = Comentario::findOrFail($id);

            if($comentario){

                $respuesta = $comentario->update($data);

                if($respuesta){

                    $evento =  EventLog::create([
                        'user_id' => Auth::id(),
                        'event_type' => 'actualizar-comentario',
                        'details' => json_encode(['place_id' => $comentario->id])
                    ]);
    
                    if($evento){
                        return [
                            'valido'=>true,
                            'comentario'=> $comentario
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
            }else{
                return [
                    'valido'=>false
                ];
            }
        }else{
            return [
                'valido'=>false
            ];
        }
    }

    public function delete(Request $request){
        
        $autenticado = Auth::user();
        if($autenticado){
            $comentario = Comentario::findOrFail($request->id);

        if($comentario){
            
            if ($autenticado->id == $comentario->user_id) {
                
                $eliminado = $comentario->delete();

                if($eliminado){

                    $evento =  EventLog::create([
                        'user_id' => Auth::id(),
                        'event_type' => 'eliminar-comentario',
                        'details' => json_encode(['place_id' => $comentario->id])
                    ]);
    
                    if($evento){
                        return [
                            'valido' => true,
                            'comentario' => $comentario->id
                        ];
                    }else{
                        return [
                            'valido' => false
                        ];
                    }
                }else{
                    return [
                        'valido' => false
                    ];
                }

                }else{
                    return [
                        'valido' => false
                    ];
                }
            }else{
                return [
                    'valido' => false
                ];
            }
        }else{
            return [
                'valido' => false
            ];
        }
    }

    public function index(Request $request){
        $url = $request->url;

        if($url){

            $lugar = LugarTuristico::where('url',$url)->first();

            if($lugar){

                $comentarios = Comentario::with('user')
                ->where('lugar_turistico_id', $lugar->id)
                ->get();
                if($comentarios->isEmpty()){
                    return [
                        'valido' => true,
                        'comentario' => ComentarioResource::collection($comentarios)
                    ];
                }else{
                    return [
                        'valido'=>false,
                        'array'=> $comentarios
                    ];
                }
            }else{
                return [
                    'valido'=>false
                ];    
            }
        }else{
            return [
                'valido'=>false
            ];
        }
    }

    public function obtenerPorUsuario(){
        
        $autenticado = Auth::user();

        if($autenticado){
            
            $comentarios = Comentario::where('user_id', $autenticado->id)->get();
            
            if($comentarios->isEmpty()){
                return [
                    'valido' => true,
                    'comentarios' => $comentarios
                ];
            }else{
                return [
                    'valido' => false
                ];
            }
        }else{
            return [
                'valido' => false
            ];
        }
        
    }
}
