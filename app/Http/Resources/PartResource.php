<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'         => $this->uuid,
            'name'         => $this->name,
            'serialnumber' => $this->serialnumber,
            'car'          => [
                'name' => $this->car->name,
                'uuid' => $this->car->uuid,
                'href' => route('cars', ['search' => $this->car->name]),
            ],
        ];
    }
}
