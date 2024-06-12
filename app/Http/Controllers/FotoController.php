<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\User;
use App\Models\Foto;

class FotoController extends Controller
{

    public function index(Request $request)
    {

        $autenticado = $request->user();
        $emprendedor = User::findOrFail($request->usuario);

        if(($autenticado->id == $emprendedor->id) || $autenticado->rol == 0){
            $imagenes = Foto::where('lugar_turistico_id', $request->lugar)->get();

            return[
                'valido'=>true,
                'imagenes'=>$imagenes
            ];
        }
            return[
                'valido'=>false,
                'imagenes'=>$imagenes
            ];
    }

    public function store(Request $request)
    {
        $autenticado =  $request->user();
        $emprendedor = User::findOrFail($request->usuario);

        if(($autenticado->id == $emprendedor->id) || $autenticado->rol == 0){
            $imagenTemporal = $_FILES['imagen']['tmp_name'];
            $nombreOriginal = $_FILES['imagen']['name'];

             // Procesar y guardar la imagen
            $nombreImg = ImageService::procesarYGuardar($imagenTemporal, $nombreOriginal,500,300);

            $foto = Foto::create([
                'url' => $nombreImg,
                'lugar_turistico_id' => $request->lugar,
            ]);

            return [
                'valido'=>true,
                'imagen'=>$foto
            ];
        }
        return [
            'valido' => false

        ];
        
    }

    public function destroy($id)
    {
            
        $foto = Foto::findOrFail($id);
        
        if($foto->url){
            $this->eliminarImagenesAnteriores($foto->url);
        }
        // Eliminar lugar turistico
        $eliminado = $foto->delete();

        
        if($eliminado){
            return [
                'valido'=>true,
                'imagen'=>$foto->url
            ];
        }
        return [
            'valido'=>false
        ];
    }

    private function eliminarImagenesAnteriores($nombreImagen)
    {
        $extensiones = ['webp', 'avif'];

        foreach ($extensiones as $ext) {
            $ruta = public_path('imagenes/') . pathinfo($nombreImagen, PATHINFO_FILENAME) . '.' . $ext;
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
    }
}
