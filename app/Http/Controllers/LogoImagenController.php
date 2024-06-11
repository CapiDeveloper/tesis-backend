<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LugarTuristico;
use App\Services\ImageService;

class LogoImagenController extends Controller
{
    public function actualizarLogo(Request $request) {


        $imagenTemporal = $_FILES['logo']['tmp_name'];
        $nombreOriginal = $_FILES['logo']['name'];

        $lugarTuristico = LugarTuristico::findOrFail($_POST['id']);
        $nombreImg = ImageService::procesarYGuardar($imagenTemporal, $nombreOriginal,200,200);
        
        if($lugarTuristico->logo){
            $this->eliminarImagenesAnteriores($lugarTuristico->logo);
        }

        $lugarTuristico->logo = $nombreImg;
        $lugarTuristico->update();

        return [
            'valido'=>true,
            'imagen'=>$nombreImg
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
