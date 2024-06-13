<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.string' => 'El nombre es incorrecto',
        ];
    }
}
