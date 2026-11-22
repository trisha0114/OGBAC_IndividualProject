<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;

class UpdateCustomerRequest extends BaseCustomerRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Describe the request body parameters for Scribe.
     */
    public function bodyParameters(): array
    {
        return [
            'data' => [
                'description' => 'The JSON:API customer resource object.',
            ],
            'data.attributes.name' => [
                'description' => 'The updated full name of the customer.',
                'example' => 'Juan Dela Cruz',
            ],
            'data.attributes.age' => [
                'description' => 'The updated age of the customer.',
                'example' => 25,
            ],
            'data.attributes.contactNumber' => [
                'description' => 'The updated contact number of the customer.',
                'example' => '09171234567',
            ],
            'data.attributes.address' => [
                'description' => 'The updated residential address of the customer.',
                'example' => 'Puerto Princesa City, Palawan',
            ],
            'data.relationships.user.data.id' => [
                'description' => 'The ID of the user associated with this customer. Only users with the appropriate permission can change ownership.',
                'example' => 1,
            ],
        ];
    }

    public function rules(): array
    {
        $rules = [
            'data' => ['sometimes', 'array'],
            'data.attributes' => ['sometimes', 'array'],

            'data.attributes.name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'data.attributes.age' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'data.attributes.contactNumber' => [
                'sometimes',
                'string',
                'max:20',
            ],

            'data.attributes.address' => [
                'sometimes',
                'string',
            ],

            'data.relationships' => ['sometimes', 'array'],
            'data.relationships.user' => ['sometimes', 'array'],
            'data.relationships.user.data' => ['sometimes', 'array'],

            // Deny by default: nobody may change the customer owner.
            'data.relationships.user.data.id' => [
                'prohibited',
            ],
        ];

        // Only authenticated users with broad permission may change the owner.
        $user = $this->user();

        if ($user && $user->tokenCan(Abilities::UpdateCustomer)) {
            $rules['data.relationships.user.data.id'] = [
                'sometimes',
                'integer',
                'exists:users,id',
            ];
        }

        return $rules;
    }
}
