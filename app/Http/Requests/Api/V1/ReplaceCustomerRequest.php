<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;

class ReplaceCustomerRequest extends BaseCustomerRequest
{
    public function authorize(): bool
    {
        return true;
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

        // Only managers with broad update permission can change ownership.
        if ($this->user()->tokenCan(Abilities::UpdateCustomer)) {
            $rules['data.relationships.user.data.id'] = [
                'required',
                'integer',
                'exists:users,id',
            ];
        }

        return $rules;
    }
}
