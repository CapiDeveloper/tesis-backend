<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LugarTuristico;

class Foto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'url',
        'lugar_turistico_id',
    ];

    public function lugarTuristico()
    {
        return $this->belongsTo(LugarTuristico::class);
    }

}
