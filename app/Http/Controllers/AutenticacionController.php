<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RegistroUsuarioRequest;

use App\Models\User;

class AutenticacionController extends Controller
{
    public function registro(RegistroUsuarioRequest $request){
        
        // $data = $request->validated();

        return [
            'user' => true
        ];

        // Crear el usuario
        $user = User::create([
            'name' => $data['name'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'rol' => 1
        ]);

        return [
            'user' => true
        ];
    }
    public function eliminar(Request $request){
        
        // $data = $request->validated();
        echo 'Hola';
        return;

        // // Crear el usuario
        // $user = User::create([
        //     'name' => $data['name'],
        //     'apellido' => $data['apellido'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        //     'rol' => 1
        // ]);

        // return [
        //     'user' => true
        // ];
    }
}
