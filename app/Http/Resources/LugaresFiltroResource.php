<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LugaresFiltroResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'url' => $this->url,
            'descripcion' => $this->descripcion,
            'fotos' => $this->fotos->map(function ($foto) {
                return [
                    'url' => $foto->url,
                ];
            }),
            'tipo' => [
                'nombre' => $this->tipo->nombre,
            ],
        ];
    }
}
