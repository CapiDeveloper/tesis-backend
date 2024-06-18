<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LugarTuristico;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
    ];

    public function lugares()
    {
        return $this->hasMany(LugarTuristico::class, 'tipo_id');
    }
}
