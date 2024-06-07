<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;

class TipoController extends Controller
{

    public function index()
    {
        $tipos = Tipo::all();
        return [
            'tipos'=>$tipos
        ];
    }

    public function store(Request $request)
    {
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
    }
}