<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorarioRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'inicio' => 'required|date_format:H:i',
            'finaliza' => 'required|date_format:H:i',
            'dia' => 'required|string',
            'lugar_turistico_id' => 'required|exists:lugar_turisticos,id',
        ];
    }

    public function messages(){
        return [
            'inicio.required' => 'El inicio es obligatorio',
            'finaliza.required' => 'El finaliza es obligatorio',
            'dia.required' => 'El dia es obligatorio',
            'lugar_turistico_id.required' => 'El lugar turistico es obligatorio',
        ];
    }
}
