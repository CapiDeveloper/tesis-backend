<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RestablecerClaveMailable;

class OlvidarClaveController extends Controller
{
    public function enviarEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'No user found with that email address.'], 404);
        }

        // Generar el token de restablecimiento de contraseña
        $token = Str::random(60);

        // Guardar el token en la base de datos
        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Crear la URL de restablecimiento de contraseña
        $restablecerUrl = '/restablecer-clave/'.$token;

        // Enviar el correo electrónico con el enlace de restablecimiento de contraseña
        Mail::to($request->email)->send(new RestablecerClaveMailable($restablecerUrl));

        return response()->json(['message' => $restablecerUrl]);
    }
}
