<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\User;
use App\Http\Requests\HorarioRequest;

class HorarioController extends Controller
{

    public function index(Request $request)
    {
        $horarios = Horario::where('lugar_turistico_id',$request->id)->get();

        return [
            'valido'=>true,
            'horarios'=> $horarios
        ];
    }

    public function store(HorarioRequest $request)
    {
        $data = $request->validated();

        $autenticado =  $request->user();
        $emprendedor = User::findOrFail($request->usuario);

        if(($autenticado->id == $emprendedor->id) || $autenticado->rol == 0){
            
            $horario = Horario::create([
                'inicio' => $data['inicio'],
                'finaliza' => $data['finaliza'],
                'dia' => $data['dia'],
                'lugar_turistico_id' => $data['lugar_turistico_id'],
            ]);

            return [
                'valido' => true,
                'horario'=> $horario
            ];

        }
        else{
            return [
                'valido' => false
            ];
        }
    }

    public function update(HorarioRequest $request, $id)
    {
        $data = $request->validated();
        $horario = Horario::findOrFail($id);

        $respuesta =  $horario->update($data);

        if ($respuesta) {
            return [
                'valido' => true,
                'horario' => $horario
            ];
        } else {
            return [
                'valido' => false
            ];
        }

    }

    public function destroy($id)
    {

        $tipo = Horario::findOrFail($id);
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
