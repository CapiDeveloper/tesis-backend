<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Tipo;
use App\Models\Foto;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lugarTuristico) {
            $lugarTuristico->url = self::generateUrl($lugarTuristico->nombre);
        });

        static::updating(function ($lugarTuristico) {
            $lugarTuristico->url = self::generateUrl($lugarTuristico->nombre);
        });
    }

    public static function generateUrl($name)
    {
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $url = Str::slug($name, '-');

        // Asegurar que el URL es único
        $originalUrl = $url;
        $count = 1;

        while (self::where('url', $url)->exists()) {
            $url = "{$originalUrl}-{$count}";
            $count++;
        }

        return $url;
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class);
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class, 'lugar_turistico_id');
    }

}
