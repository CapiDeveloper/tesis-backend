<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IniciarSesionRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email','exists:users,email'],
            'password'=>['required']
        ];
    }

    public function messages(){
        return [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.exists' => 'La cuenta no existe',
            'password' => 'El password es obligatorio',
        ];
    }
}
