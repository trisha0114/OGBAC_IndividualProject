<?php

namespace App\Http\Requests\Api\V1;

class StoreCustomerRequest extends BaseCustomerRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
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
        ];

        // Standalone customer creation requires a user ID.
        // Nested creation gets the user ID from the URL.
        if (!$this->route('user')) {
            $rules['data.relationships.user.data.id'] = [
                'required',
                'integer',
                'exists:users,id',
            ];
        }

        return $rules;
    }
}
