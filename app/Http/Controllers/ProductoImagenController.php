<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Services\ImageService;

class ProductoImagenController extends Controller
{

    public function actualizarimagen(Request $request) {

        $imagenTemporal = $_FILES['imagen']['tmp_name'];
        $nombreOriginal = $_FILES['imagen']['name'];

        $producto = Producto::findOrFail($_POST['id']);
        
        $nombreImg = ImageService::procesarYGuardar($imagenTemporal, $nombreOriginal,200,200);
        
        if($producto->imagen){
            $this->eliminarImagenesAnteriores($producto->imagen);
        }

        $producto->imagen = $nombreImg;
        $producto->update();

        $productoRetornar = Producto::with('categoria')->findOrFail($producto->id);

        return [
            'valido'=>true,
            'producto'=>$productoRetornar
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
