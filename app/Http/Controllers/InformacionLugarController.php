<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LugaresFiltroRequest;
use App\Http\Resources\LugaresFiltroResource;
use App\Http\Resources\LugaresMapaResource;
use App\Http\Resources\OfertasLugarResource;
use App\Models\LugarTuristico;
use App\Models\Horario;
use App\Models\Producto;
use App\Models\Foto;
use App\Models\Servicio;
use App\Models\Tipo;
use App\Models\Oferta;
use App\Models\EventLog;

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

    public function obtenerOfertasLugar(Request $request) {

        $lugar = LugarTuristico::where('url',$request->url)->first();
        
        if($lugar){
            $ofertas = Oferta::where('lugar_turistico_id', $lugar->id)->get();
            return [
                'valido' => true,
                'oferta'=> OfertasLugarResource::collection($ofertas)
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

            $lugaresConUnaFoto = LugarTuristico::inRandomOrder()->limit(3)->get();

            if($lugaresConUnaFoto){
                return [
                    'valido' => true,
                    'lugaresSidebar'=> LugaresFiltroResource::collection($lugaresConUnaFoto)
                ];
            }else{
                return [
                    'valido' => false,
                ];
            }
    }

    public function obtenerLugaresCategoria(Request $request) {

        $tipoNombre = $request->nombre;

        if($tipoNombre){
            $tipo = Tipo::where('nombre',$tipoNombre)->first();

           if($tipo){
                $lugaresPorTipo = LugarTuristico::with('tipo')
                ->where('tipo_id', $tipo->id)
                ->get();
        
                return [
                    'valido'=>true,
                    'lugaresPorTipo' => LugaresFiltroResource::collection($lugaresPorTipo)
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

    public function obtenerLugaresFiltro(LugaresFiltroRequest $request) {

        $data = $request->validated();
        
        if($data){

            $lugaresTuristicos = LugarTuristico::with('tipo')
            ->where(function ($query) use ($data) {
                $query->where('nombre', 'like', "%{$data['busqueda']}%")
                      ->orWhere('descripcion', 'like', "%{$data['busqueda']}%");
            })
            ->get();

            if($lugaresTuristicos->empty()){
                return [
                    'valido' => true,
                    'lugares'=> LugaresFiltroResource::collection($lugaresTuristicos)
                ];
            }
        }else{

            return [
                'valido' => false,
            ];
        }
    }

    public function obtenerCategorias(Request $request) {

        $categorias = Tipo::all();
        
        if($categorias){

            return [
                'valido' => true,
                'categorias'=> $categorias
            ];
            
        }else{
            return [
                'valido' => false,
            ];
        }
    }

    public function obtenerLugaresPopulares(Request $request) {

        $lugaresConUnaFoto = LugarTuristico::with('tipo')
        ->whereIn('id', [20,21,22])
        ->get();

        if ($lugaresConUnaFoto->isEmpty()) {
            return [
                'valido' => false,
            ];
        }

        return [
            'valido' => true,
            'lugaresPopulares' => LugaresFiltroResource::collection($lugaresConUnaFoto)
        ];

    }
    public function obtenerLugaresOfertas(){
        
        $lugaresRelacionados = LugarTuristico::whereHas('ofertas')
            ->with('ofertas')
            ->limit(3)
            ->get();

        if($lugaresRelacionados){
            return [
                'valido'=>true,
                'LugaresOfertas' => LugaresFiltroResource::collection($lugaresRelacionados)
            ];
        }else{
            return [
                'valido'=>false,
                'LugaresOfertas' => $lugaresRelacionados
            ];
        }

    }

    public function lugaresMapa(){
        $lugares = LugarTuristico::all();
        return [
            'valido' => true,
            'lugares' => LugaresMapaResource::collection($lugares)
        ];
    }

}