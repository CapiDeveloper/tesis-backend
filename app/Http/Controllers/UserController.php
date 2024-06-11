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
            'rol' => 1,
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
    public function obtenerLugares(){
        $usuarios = User::all();
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
