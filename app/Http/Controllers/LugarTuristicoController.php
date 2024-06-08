<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LugarTuristicoRequest;
use App\Models\LugarTuristico;

class LugarTuristicoController extends Controller
{

    public function index()
    {
        //
    }

    public function store(LugarTuristicoRequest $request)
    {
        $data = $request->validated();
        // $user = LugarTuristico::create([
        //     'nombre' => $data['nombre'],
        //     'apellido' => $data['apellido'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        //     'imagen' => '',
        //     'rol' => 1,
        //     'verification_token' => Str::random(60) // Generar y guardar el token de verificación
        // ]);
        return [
            'valido'=>$request
        ];
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
