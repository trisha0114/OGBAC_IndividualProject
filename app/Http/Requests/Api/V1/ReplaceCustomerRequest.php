<?php

namespace App\Http\Requests\Api\V1;

class ReplaceCustomerRequest extends BaseCustomerRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data' => ['required', 'array'],
            'data.attributes' => ['required', 'array'],
            'data.attributes.name' => ['required', 'string', 'max:255'],
            'data.attributes.age' => ['required', 'integer', 'min:1'],
            'data.attributes.contactNumber' => ['required', 'string', 'max:20'],
            'data.attributes.address' => ['required', 'string'],
            'data.relationships' => ['required', 'array'],
            'data.relationships.user' => ['required', 'array'],
            'data.relationships.user.data' => ['required', 'array'],
            'data.relationships.user.data.id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}