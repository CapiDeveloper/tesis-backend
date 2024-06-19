<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LugaresFiltroRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'busqueda' => 'required|string|max:30',
        ];
    }

    public function messages(){
        return [
            'busqueda.required' => 'El inicio es obligatorio',
            'busqueda.string' => 'El finaliza es obligatorio',
            'busqueda.max' => 'El precio debe ser un número',
        ];
    }
}
