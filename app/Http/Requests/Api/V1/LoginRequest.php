<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => [
                'description' => 'The registered email address of the user.',
                'example' => 'juan@example.com',
            ],
            'password' => [
                'description' => 'The password associated with the account.',
                'example' => 'Password123',
            ],
        ];
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
