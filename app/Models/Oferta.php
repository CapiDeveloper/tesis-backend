<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'inicia',
        'finaliza',
        'lugar_turistico_id',
    ];
}
