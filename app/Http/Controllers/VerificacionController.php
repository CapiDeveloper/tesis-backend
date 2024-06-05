<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VerificacionController extends Controller
{
    public function verificarEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return [
                'valido'=>false
            ];
        }

        $user->email_verified_at = now();
        $user->verification_token = null; // Eliminar el token de verificación
        $user->save();

        return [
            'valido'=>true
        ];
    }
}
