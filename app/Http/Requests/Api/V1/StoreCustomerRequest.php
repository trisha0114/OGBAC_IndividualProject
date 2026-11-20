<?php

namespace App\Http\Requests\Api\V1;

class StoreCustomerRequest extends BaseCustomerRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating a customer.
     */
    public function rules(): array
    {
        return [
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

            'data.relationships.user.data.id' => [
                'sometimes',
                'exists:users,id',
            ],
        ];
    }
}