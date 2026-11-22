<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;

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

        if (!$this->route('user')) {
            $user = $this->user();

            $userIdAttr = 'data.relationships.user.data.id';

            $userRule = [
                'required',
                'integer',
                'exists:users,id',
            ];

            if (!$user) {
                $rules[$userIdAttr] = $userRule;
                return $rules;
            }

            // Deny by default: regular users can only
            // create customers under their own account.
            $rules[$userIdAttr] = array_merge(
                $userRule,
                ['in:' . $user->id]
            );

            // Managers with broad permission may select another owner.
            if ($user->tokenCan(Abilities::CreateCustomer)) {
                $rules[$userIdAttr] = $userRule;
            }
        }

        return $rules;
    }
}