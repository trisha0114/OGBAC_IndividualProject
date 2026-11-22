<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
                'description' => 'The full name of the user.',
                'example' => 'Juan Dela Cruz',
            ],
            'email' => [
                'description' => 'The user email address. Must be unique.',
                'example' => 'juan@example.com',
            ],
            'password' => [
                'description' => 'The user password. Minimum of 8 characters.',
                'example' => 'Password123',
            ],
            'password_confirmation' => [
                'description' => 'Must match the password.',
                'example' => 'Password123',
            ],
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
