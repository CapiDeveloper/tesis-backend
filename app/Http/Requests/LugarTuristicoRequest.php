<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LugarTuristicoRequest extends FormRequest
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
            'nombre' => ['required'],
            'descripcion' => ['required'],
            'direccion' => ['required'],
            'latitud' => ['required'],
            'longitud' => ['required'],
            'contacto' => ['required'],
            'logo' => ['required'],
            'user_id' => ['required'],
            'tipo_id' => ['required'],
        ];
    }
    public function messages(){
        return [
            'nombre' => 'El nombre es obligatorio',
            'descripcion' => 'La descripción es obligatorio',
            'direccion' => 'La dirección es obligatorio',
            'latitud' => 'La latitud es obligatorio',
            'longitud' => 'La longitud es obligatorio',
            'contacto' => 'El contacto es obligatorio',
            'logo' => 'El logo es obligatorio',
            'user_id' => 'El usuario es obligatorio',
            'tipo_id' => 'El tipo es obligatorio',
        ];
    }
}
