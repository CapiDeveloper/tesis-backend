<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;


class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
        'lugar_turistico_id',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}
