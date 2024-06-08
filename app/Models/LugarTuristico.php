<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarTuristico extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'direccion',
        'longitud',
        'latitud',
        'contacto',
        'mapa',
        'logo',
        'user_id',
        'tipo_id',
    ];
}
