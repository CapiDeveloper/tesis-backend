<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicioRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'lugar_turistico_id' => 'required|exists:lugar_turisticos,id',
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'El inicio es obligatorio',
            'precio.required' => 'El finaliza es obligatorio',
            'precio.numeric' => 'El precio debe ser un número',
            'lugar_turistico_id.required' => 'El lugar turistico es obligatorio',
        ];
    }
}
