<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;

class UpdateCustomerRequest extends BaseCustomerRequest
{
    public function authorize(): bool
    {
        return true;
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

        // Only users with broad permission may change the owner.
        if ($this->user()->tokenCan(Abilities::UpdateCustomer)) {
            $rules['data.relationships.user.data.id'] = [
                'sometimes',
                'integer',
                'exists:users,id',
            ];
        }

        return $rules;
    }
}
