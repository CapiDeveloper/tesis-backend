<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;

class CategoriaController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if($user->rol == 0){
            $categorias = Categoria::all();
            
            return [
                'valido' => true,
                'categorias'=> $categorias
            ];
        }else{
            return [
                'valido' => false
            ];
        }
    }

    public function store(CategoriaRequest $request)
    {

        $user = Auth::user();

        if($user->rol == 0){
            $data = $request->validated();
        
            $categoria = Categoria::create([
                'nombre' => $data['nombre']
            ]);

            return [
                'valido' => true,
                'categoria'=> $categoria
            ];
        }else{
            return [
                'valido' => false
            ];
        }

    }

    public function update(CategoriaRequest $request, $id)
    {
        $user = Auth::user();

        if($user->rol == 0){

            $data = $request->validated();
            $categoria = Categoria::findOrFail($id);

            $respuesta = $categoria->update($data);

            if ($respuesta) {
                return [
                    'valido' => true,
                    'categoria' => $categoria
                ];
            } else {
                return [
                    'valido' => false
                ];
            }
        }else{
            return [
                'valido'=>false
            ];
        }
    }

    public function destroy($id)
    {
        
        $user = Auth::user();

        if($user->rol == 0){
            $categoria = Categoria::findOrFail($id);
            $eliminado = $categoria->delete();

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
