<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComentarioRequest extends FormRequest
{
 
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comentario' => 'required|string',
            'valoracion' => 'required',
            'user_id' => 'required|exists:users,id',
            'lugar_turistico_id' => 'required|exists:lugar_turisticos,id',
        ];
    }

    public function messages(){
        return [
            'comentario.required' => 'El comentario es obligatorio',
            'comentario.string' => 'El comentario es incorrecto',
            'valoracion.required' => 'La valoración es obligatorio',
            'user_id.required' => 'No esta autenticado',
            'lugar_turistico_id.required' => 'El lugar turistico es incorrecto',
            'lugar_turistico_id.exists' => 'El lugar turistico no existe',
        ];
    }
}
