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
            'busqueda' => 'required',
        ];
    }

    public function messages(){
        return [
            'busqueda.required' => 'El inicio es obligatorio',
        ];
    }
}
