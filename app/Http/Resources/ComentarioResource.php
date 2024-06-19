<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComentarioResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comentario' => $this->comentario,
            'valoracion' => $this->valoracion,
            'created_at' => $this->created_at,
            'user' => [
                'nombre' => $this->user->nombre,
                'imagen' => $this->user->imagen,
                'apellido' => $this->user->apellido,
            ],
        ];
    }
}
