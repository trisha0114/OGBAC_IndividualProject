<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => [
                'description' => 'The updated full name of the user.',
                'example' => 'Juan Dela Cruz',
            ],
            'email' => [
                'description' => 'The updated email address. Must be unique.',
                'example' => 'juan@example.com',
            ],
            'password' => [
                'description' => 'The new password. Minimum of 8 characters.',
                'example' => 'NewPassword123',
            ],
            'password_confirmation' => [
                'description' => 'Must match the new password.',
                'example' => 'NewPassword123',
            ],
            'is_manager' => [
                'description' => 'Indicates whether the user has manager privileges.',
                'example' => true,
            ],
        ];
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => [
                'sometimes',
                'string',
                'min:8',
                'confirmed',
            ],
            'is_manager' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
