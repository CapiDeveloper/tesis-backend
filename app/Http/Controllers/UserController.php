<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistroUsuarioRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificarCuentaMailable;
use App\Http\Resources\UserResource;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function registro(RegistroUsuarioRequest $request)
    {
        
        $data = $request->validated();

        // Crear el usuario
        $user = User::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'imagen' => '',
            'rol' => $data['rol'],
            'verification_token' => Str::random(60) // Generar y guardar el token de verificación
        ]);

        // Generar la URL de verificación
        $verificationUrl = $user->verification_token;

        // Enviar el correo electrónico con la URL de verificación
        Mail::to($user->email)->send(new VerificarCuentaMailable($verificationUrl));

        return [
            'user' => true
        ];
    }

    public function actualizar(Request $request){
        $autenticado = Auth::user();

        if($autenticado->id == $request->id){
            $usuario = User::findOrFail($request->id);
            
            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;

            $guardar =  $usuario->save();

            if($guardar){
                return [
                    'usuario' => $usuario,
                    'valido' => true
                ];    
            }else{
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

    public function obtenerUsuarios(){

        $usuarios = User::where(function($query) {
            $query->where('rol', 0)
                  ->orWhere('rol', 1);
        })->get();
        
        return [
            'valido'=>true,
            'usuarios'=> UserResource::collection($usuarios)
        ];
    }

    public function subirImagenPerfil(Request $request){

        $user = User::findOrFail($request->user()->id);
        // Eliminar imágenes anteriores si existen
        if ($user->imagen) {
            $this->eliminarImagenesAnteriores($user->imagen);
        }

        $imagenTemporal = $_FILES['image']['tmp_name'];
        $nombreOriginal = $_FILES['image']['name'];

        // Procesar y guardar la imagen
        $nombreImg = ImageService::procesarYGuardar($imagenTemporal, $nombreOriginal,120,120);

        $user->imagen = $nombreImg;
        $user->save();

        return [
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
