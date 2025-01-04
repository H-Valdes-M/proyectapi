<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->name->name, // Asegúrate de que 'name' es un campo válido en tu modelo Usuario
            ],
            'tribunal' => [
                'id' => $this->tribunal->id,
                'nombre_Tribunal' => $this->tribunal->nombre_Tribunal, // Asegúrate de que 'name' es un campo válido en tu modelo Tribunal
            ],
            'fecha' => $this->fecha,
            'destinatario' => $this->destinatario,
            'observacion' => $this->observacion,
            'guiadeMov' => $this->guiadeMov,
            'nguiaMov' => $this->nguiaMov,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
