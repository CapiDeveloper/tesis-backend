<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RestablecerClaveController extends Controller
{
    public function restablecer(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$passwordReset || $passwordReset->email !== $request->email) {
            return response()->json(['message' => 'This password reset token is invalid.'], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'No user found with that email address.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar el token de restablecimiento de la base de datos
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password has been reset.']);
    }
}
