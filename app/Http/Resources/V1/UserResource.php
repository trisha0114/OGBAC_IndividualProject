<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\CustomerResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => (string) $this->id,

            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
            ],

            'relationships' => [
                'customers' => CustomerResource::collection(
                    $this->whenLoaded('customers')
                ),
            ],
        ];
    }
}