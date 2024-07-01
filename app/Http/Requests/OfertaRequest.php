<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfertaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'inicia' => 'required|date|date_format:Y-m-d',
            'finaliza' => 'required|date|date_format:Y-m-d',
            'lugar_turistico_id' => 'required|exists:lugar_turisticos,id',
        ];
    }

    public function messages(){
        return [
            'titulo.required' => 'El titulo es obligatorio',
            'descripcion.required' => 'La descripción es obligatorio',
            'inicia.required' => 'El fecha de inicio es obligatorio',
            'inicia.date_format' => 'El formato de fecha es incorrecto',
            'finaliza.required' => 'El finaliza es obligatorio',
            'finaliza.date_format' => 'El finaliza es incorrecto',
            'lugar_turistico_id.required' => 'El lugar turistico es obligatorio',
        ];
    }
}
