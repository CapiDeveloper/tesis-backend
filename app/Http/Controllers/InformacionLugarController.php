<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LugaresFiltroRequest;
use App\Models\LugarTuristico;
use App\Models\Horario;
use App\Models\Producto;
use App\Models\Foto;
use App\Models\Servicio;
use App\Models\Tipo;

class InformacionLugarController extends Controller
{
    public function obtenerLugar(Request $request) {

        $lugar = LugarTuristico::with('tipo')->where('url',$request->url)->first();
        
        if($lugar){
            return [
                'valido' => true,
                'lugar'=> $lugar
            ]; 
        }
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

    public function obtenerImagen(Request $request) {

        $lugar = LugarTuristico::where('url',$request->url)->first();
        
        if($lugar){
            $fotos = Foto::where('lugar_turistico_id', $lugar->id)
                    ->get();
            return [
                'valido' => true,
                'foto'=> $fotos
            ];
        }
    }
    public function obtenerServicio(Request $request) {

        $lugar = LugarTuristico::where('url',$request->url)->first();
        
        if($lugar){
            $servicios = Servicio::where('lugar_turistico_id', $lugar->id)
                    ->get();
            return [
                'valido' => true,
                'servicio'=> $servicios
            ];
        }
    }

    public function obtenerLugaresSidebar(Request $request) {

        $lugar = LugarTuristico::where('url',$request->url)->first();
        
        if($lugar){

            $lugaresConUnaFoto = LugarTuristico::inRandomOrder()->limit(3)->get();


            $lugaresConUnaFoto->each(function ($lugar) {
                $lugar->load(['fotos' => function($query) {
                    $query->take(1); 
                }]);
            });

            return [
                'valido' => true,
                'lugaresSidebar'=> $lugaresConUnaFoto
            ];
        }
    }

    public function obtenerLugaresCategoria(Request $request) {

        $tipo = Tipo::find($request->id);
        
        if($tipo){

            $lugaresTuristicos = $tipo->lugares;

            return [
                'valido' => true,
                'lugares'=> $lugaresTuristicos
            ];
        }else{
            return [
                'valido' => false,
            ];
        }
    }

    public function obtenerLugaresFiltro(LugaresFiltroRequest $request) {

        $data = $request->validated();
        
        if($data){

            $lugaresTuristicos = LugarTuristico::where('nombre', 'like', "%{$data['busqueda']}%")
        ->orWhere('descripcion', 'like', "%{$data['busqueda']}%")
        ->get();

            return [
                'valido' => true,
                'lugares'=> $lugaresTuristicos
            ];
        }else{

            return [
                'valido' => false,
            ];
        }
    }
}