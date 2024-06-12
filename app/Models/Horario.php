<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'inicio',
        'finaliza',
        'dia',
        'lugar_turistico_id',
    ];
}
