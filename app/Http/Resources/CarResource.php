<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'               => $this->uuid,
            'name'               => $this->name,
            'registrationNumber' => $this->registration_number,
            'isRegistered'       => $this->is_registered,
        ];
    }
}
