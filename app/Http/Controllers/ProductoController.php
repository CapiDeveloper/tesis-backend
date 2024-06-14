<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageService;
use App\Models\Producto;
use App\Models\User;


class ProductoController extends Controller
{
    public function index(Request $request)
    {

        $productos = Producto::where('lugar_turistico_id', $request->id)
        ->with('categoria')
        ->get();

        return [
            'valido'=>true,
            'productos'=> $productos
        ];
    }

    public function store(ProductoRequest $request)
    {
        $data = $request->validated();

        $emprendedor = User::findOrFail($request->usuario);
        $autenticado = Auth::user();

        if(($autenticado->id == $emprendedor->id) || $autenticado->rol == 0){
            $imagenTemporal = $_FILES['imagen']['tmp_name'];
            $nombreOriginal = $_FILES['imagen']['name'];

            // Procesar y guardar la imagen
            $nombreImg = ImageService::procesarYGuardar($imagenTemporal, $nombreOriginal,350,350);

            $producto = Producto::create([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'],
                'precio' => $data['precio'],
                'imagen' => $nombreImg,
                'lugar_turistico_id' => $request->lugar_turistico_id,
                'categoria_id' => $request->categoria_id,
            ]);

            $productoRetornar = Producto::with('categoria')->findOrFail($producto->id);

                if($productoRetornar->id){
                    return [
                        'valido'=> true,
                        'producto'=>$productoRetornar
                    ];
                }else{
                        return [
                    'valido'=> false
                ];
            }   
            }else{
                return[
                    'valido' => false
                ];
        }

    }

    public function update(ProductoRequest $request, $id)
    {
        $data = $request->validated();

        $emprendedor = User::findOrFail($request->usuario);
        $autenticado = Auth::user();

        if(($autenticado->id == $emprendedor->id) || $autenticado->rol == 0){
            $producto = Producto::with('categoria')->findOrFail($id);
            $respuesta = $producto->update($data);

            if ($respuesta) {
                return[
                    'valido' => true,
                    'producto'=>$producto
                ];    
            }else{
                return[
                    'valido' => false
                ];
            }
        }else{
            return[
                'valido' => false
            ];
        }
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        if($producto->imagen){
            $this->eliminarImagenesAnteriores($producto->imagen);
        }

        $eliminado = $producto->delete();
        
        if($eliminado){
            return [
                'valido'=>$producto->id
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
