<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServicioRequest;
use App\Models\Servicio;

class ServicioController extends Controller
{

    public function index(Request $request)
    {
        $servicios = Servicio::where('lugar_turistico_id',$request->id)->get();

        return [
            'valido'=>true,
            'servicios'=> $servicios
        ];
    }

    public function store(ServicioRequest $request)
    {
        $data = $request->validated();
        
        $servicio = Servicio::create([
            'nombre' => $data['nombre'],
            'precio' => $data['precio'],
            'lugar_turistico_id' => $data['lugar_turistico_id'],
        ]);

        return [
            'valido' => true,
            'servicio' => $servicio
        ];

    }

    public function update(ServicioRequest $request, $id)
    {
        $data = $request->validated();
        $servicio = Servicio::findOrFail($id);

        $respuesta =  $servicio->update($data);

        if ($respuesta) {
            return [
                'valido' => true,
                'servicio' => $servicio
            ];
        } else {
            return [
                'valido' => false
            ];
        }
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $eliminado = $servicio->delete();
        
        if($eliminado){
            return [
                'valido'=>$servicio->id
            ];
        }
        return [
            'valido'=>false
        ];
    }
}
