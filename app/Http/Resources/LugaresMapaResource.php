<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LugaresMapaResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'url' => $this->url,
            'logo' => $this->logo,
            'longitud' => $this->longitud,
            'latitud' => $this->latitud,
        ];
    }
}
