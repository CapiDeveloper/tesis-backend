<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;
use Illuminate\Support\Facades\Auth;

class TipoController extends Controller
{

    public function index()
    {

        $user = Auth::user();

        if($user->rol == 0 || $user->rol == 1){
            $tipos = Tipo::all();
            return [
                'valido'=>true,
                'tipos'=>$tipos
            ];
        }else{
            return [
                'valido'=>false
            ]; 
        }
    }

    public function store(Request $request)
    {

        $user = Auth::user();

        if($user->rol == 0){
            $tipo = new Tipo;
            $tipo->nombre = $request->nombre;
            
            $respuesta = $tipo->save();

            if($respuesta){

                $tipo = Tipo::findOrFail($tipo->id);
                return [
                    'valido'=>true,
                    'tipo'=>$tipo
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

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if($user->rol == 0){
            $tipo = Tipo::findOrFail($id);
            $tipo->nombre = $request->nombre;

            $respuesta = $tipo->save();

            if ($respuesta) {
                return [
                    'valido' => true,
                    'tipo' => $tipo
                ];
            } else {
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

    public function destroy($id)
    {
        $user = Auth::user();

        if($user->rol == 0){
            $tipo = Tipo::findOrFail($id);
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
                'valido'=>false
            ];
        }
    }
}