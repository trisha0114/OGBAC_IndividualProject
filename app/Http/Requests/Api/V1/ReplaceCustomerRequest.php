<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;

class ReplaceCustomerRequest extends BaseCustomerRequest
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
                'description' => 'The full name of the customer.',
                'example' => 'Juan Dela Cruz',
            ],
            'data.attributes.age' => [
                'description' => 'The age of the customer.',
                'example' => 25,
            ],
            'data.attributes.contactNumber' => [
                'description' => 'The contact number of the customer.',
                'example' => '09171234567',
            ],
            'data.attributes.address' => [
                'description' => 'The residential address of the customer.',
                'example' => 'Puerto Princesa City, Palawan',
            ],
            'data.relationships.user.data.id' => [
                'description' => 'The ID of the user associated with this customer. Only managers with the appropriate permission can change ownership.',
                'example' => 1,
            ],
        ];
    }

    public function rules(): array
    {
        $rules = [
            'data' => ['required', 'array'],
            'data.attributes' => ['required', 'array'],

            'data.attributes.name' => [
                'required',
                'string',
                'max:255',
            ],

            'data.attributes.age' => [
                'required',
                'integer',
                'min:1',
            ],

            'data.attributes.contactNumber' => [
                'required',
                'string',
                'max:20',
            ],

            'data.attributes.address' => [
                'required',
                'string',
            ],

            'data.relationships' => ['required', 'array'],
            'data.relationships.user' => ['required', 'array'],
            'data.relationships.user.data' => ['required', 'array'],

            // Deny owner changes by default.
            'data.relationships.user.data.id' => [
                'prohibited',
            ],
        ];

        // Only authenticated managers with broad update permission
        // can change customer ownership.
        $user = $this->user();

        if ($user && $user->tokenCan(Abilities::UpdateCustomer)) {
            $rules['data.relationships.user.data.id'] = [
                'required',
                'integer',
                'exists:users,id',
            ];
        }

        return $rules;
    }
}
