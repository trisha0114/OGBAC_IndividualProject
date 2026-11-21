<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;

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
        $userIdAttr = 'data.relationships.user.data.id';

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

            $userIdAttr => [
                'sometimes',
                'integer',
                'exists:users,id',
            ],
        ];

        // Regular users can only create customers under their own user ID.
        $user = $this->user();

        if ($user && $user->tokenCan(Abilities::CreateOwnCustomer)) {
            $rules[$userIdAttr] = [
                'required',
                'integer',
                'exists:users,id',
                'size:' . $user->id,
            ];
        }

        return $rules;
    }
}
