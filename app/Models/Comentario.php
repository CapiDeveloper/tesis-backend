<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LugarTuristico;
use App\Models\User;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'comentario',
        'valoracion',
        'lugar_turistico_id',
        'user_id',
    ];

    public function lugarTuristico()
    {
        return $this->belongsTo(LugarTuristico::class, 'lugar_turistico_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
