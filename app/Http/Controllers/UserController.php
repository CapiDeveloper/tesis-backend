<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistroUsuarioRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificarCuentaMailable;
use App\Http\Resources\UserResource;

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
}
