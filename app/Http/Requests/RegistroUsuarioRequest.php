<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' => ['required','string'],
            'apellido' => ['required','string'],
            'email' => ['required', 'email','unique:users,email'],
            'password'=>[
                'required',
                'confirmed',
            ]
        ];
    }
    public function messages(){
        return [
            'nombre' => 'El nombre es obligatorio',
            'apellido' => 'El apellido es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El usuario ya esta registrado',
            'password.required' => 'El password es obligatorio',
            'password.confirmed' => 'El password es obligatorio',
        ];
    }
}
