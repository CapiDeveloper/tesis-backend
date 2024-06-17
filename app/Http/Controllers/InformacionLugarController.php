<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LugarTuristico;
use App\Models\Horario;
use App\Models\Producto;


class InformacionLugarController extends Controller
{
    public function obtenerLugar(Request $request) {

        $lugar = LugarTuristico::where('url',$request->url)->first();
        
        return [
            'valido' => true,
            'lugar'=> $lugar
        ]; 
    }

    public function obtenerHorario(Request $request) {

        $lugar = LugarTuristico::where('url',$request->url)->first();
        
        if($lugar){
            $horario = Horario::where('lugar_turistico_id',$lugar->id)->get();
            return [
                'valido' => true,
                'horario'=> $horario
            ];
        }
    }

    public function obtenerProducto(Request $request) {

        $lugar = LugarTuristico::where('url',$request->url)->first();
        
        if($lugar){
            $productos = Producto::with('categoria')
                    ->where('lugar_turistico_id', $lugar->id)
                    ->get();
            return [
                'valido' => true,
                'producto'=> $productos
            ];
        }
    }
}
