<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use App\Models\Producto;

class DisponibilidadProductoController extends Controller
{
    public function actualizarDisponibilidad( ProductoRequest $request ){
        $data = $request->validated();

        if($data){
            $producto = Producto::with('categoria')->findOrFail($request->id);
            $producto->disponibilidad = $request->disponibilidad;
            $guardado =  $producto->save();

            if($guardado){
                return [
                    'valido'=>true,
                    'producto'=> $producto
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
    }
}
