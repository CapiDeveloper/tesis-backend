<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OfertaRequest;
use App\Models\User;
use App\Models\Oferta;

class OfertaController extends Controller
{

    public function index(Request $request)
    {
        $horarios = Oferta::where('lugar_turistico_id',$request->id)->get();

        return [
            'valido'=>true,
            'ofertas'=> $horarios
        ];
    }

    public function store(OfertaRequest $request)
    {
        $data = $request->validated();

        $autenticado =  $request->user();
        $emprendedor = User::findOrFail($request->usuario);

        if(($autenticado->id == $emprendedor->id) || $autenticado->rol == 0){
            
            $oferta = Oferta::create([
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'],
                'inicia' => $data['inicia'],
                'finaliza' => $data['finaliza'],
                'lugar_turistico_id' => $data['lugar_turistico_id'],
            ]);

            return [
                'valido' => true,
                'oferta'=> $oferta
            ];

        }
        else{
            return [
                'valido' => false
            ];
        }

    }

    public function update(OfertaRequest $request, $id)
    {
        $data = $request->validated();
        $oferta = Oferta::findOrFail($id);

        $respuesta =  $oferta->update($data);

        if ($respuesta) {
            return [
                'valido' => true,
                'oferta' => $oferta
            ];
        } else {
            return [
                'valido' => false
            ];
        }
    }

    public function destroy($id)
    {
        $oferta = Oferta::findOrFail($id);
        $eliminado = $oferta->delete();
        
        if($eliminado){
            return [
                'valido'=>$oferta->id
            ];
        }
        return [
            'valido'=>false
        ];
    }
}
