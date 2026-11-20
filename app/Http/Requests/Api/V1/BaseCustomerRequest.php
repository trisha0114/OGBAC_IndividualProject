<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseCustomerRequest extends FormRequest
{
    /**
     * Converts the nested JSON:API payload
     * into database column names.
     */
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'data.attributes.name' => 'name',
            'data.attributes.age' => 'age',
            'data.attributes.contactNumber' => 'contact_number',
            'data.attributes.address' => 'address',
            'data.relationships.user.data.id' => 'user_id',
        ], $otherAttributes);

        $attributesToUpdate = [];

        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }

        return $attributesToUpdate;
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'data.attributes.name.required' => 'Customer name is required.',
            'data.attributes.age.required' => 'Customer age is required.',
            'data.attributes.contactNumber.required' => 'Contact number is required.',
            'data.attributes.address.required' => 'Customer address is required.',
            'data.relationships.user.data.id.exists' => 'The selected user does not exist.',
        ];
    }
}