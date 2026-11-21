<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends BaseCustomerRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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

            'data.relationships.user.data.id' => [
                'sometimes',
                'integer',
                'exists:users,id',
            ],
        ];
    }
}
