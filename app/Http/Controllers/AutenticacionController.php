<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistroUsuarioRequest;
use App\Http\Requests\IniciarSesionRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\LugarTuristico;

class AutenticacionController extends Controller
{
    public function iniciarSesion(IniciarSesionRequest $request){
        $data = $request->validated();
        // Revisar el password
        if(!Auth::attempt($data)){
            return response([
                'errors'=>['El email o contraseña son incorrectos']
            ],422);
        }

        // Autenticar el usuario
        $user = Auth::user();

        if($user->rol == 1){
            $lugar = LugarTuristico::where('user_id',$user->id)->get();
            
            if($lugar){
                return [
                    'token' => $user->createToken('token')->plainTextToken,
                    'lugar' => $lugar,
                    'user' => $user
                ];
            }else{
                return [
                    'token' => $user->createToken('token')->plainTextToken,
                    'user' => $user
                ];
            }
        }else{
            return [
                'token' => $user->createToken('token')->plainTextToken,
                'user' => $user
            ];
        }
    }
    public function cerrarSesion(Request $request){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }
}
