<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'descripcion' => 'required|string',
            'imagen' => 'required',
            'lugar_turistico_id' => 'required|exists:lugar_turisticos,id',
            'categoria_id' => 'required|exists:categorias,id',
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.string' => 'El nombre es incorrecto',
            'precio.required' => 'El precio es es obligatorio',
            'precio.numeric' => 'El precio no es numérico',
            'descripcion.required' => 'La descripcion es es obligatorio',
            'descripcion.string' => 'La descripción no es correcta',
            'imagen.required' => 'La imagen es obligatorio',
            'lugar_turistico_id.required' => 'El lugar turistico es obligatorio',
            'categoria_id.required' => 'La categoria es es obligatorio',
        ];
    }
}
