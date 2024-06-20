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

        $user = User::where('email', $data['email'])->first();
        
        if($user){
            // Revisar el password
            if(!Auth::attempt($data)){
                return response([
                    'errors'=>['El email o contraseña son incorrectos']
                ],422);
            }

            if (is_null($user->email_verified_at)) {
                // Cerrar sesión si el usuario no está verificado
                Auth::logout();
                
                return response([
                    'errors' => ['El email no ha sido verificado'],
                    'verificado' => false
                ], 422);
            }

            // Autenticar el usuario
            $user = Auth::user();

            if($user){
                return [
                    'valido' => true,
                    'token' => $user->createToken('token')->plainTextToken,
                    'user' => $user
                ];
            }else{
                return [
                    'valido' => false
                ];
            }
        }else{
            return [
                'valido'=>false
            ];
        }
    }
    public function cerrarSesion(Request $request){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }
}
