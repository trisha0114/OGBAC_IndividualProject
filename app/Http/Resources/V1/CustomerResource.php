<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'customer',
            'id' => (string) $this->id,

            'attributes' => [
                'name' => $this->name,
                'age' => $this->age,
                'contactNumber' => $this->contact_number,
                'address' => $this->address,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
        ];
    }
}