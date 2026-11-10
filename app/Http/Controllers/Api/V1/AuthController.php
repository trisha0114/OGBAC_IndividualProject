<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponses;

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        $token = auth('api')->login($user);

        return $this->success(
            'User registered successfully',
            [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
            ],
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->error('Invalid email or password', 401);
        }

        return $this->success(
            'Login successful',
            [
                'user' => auth('api')->user(),
                'access_token' => $token,
                'token_type' => 'bearer',
            ]
        );
    }

    public function me(): JsonResponse
    {
        return $this->success(
            'User retrieved successfully',
            auth('api')->user()
        );
    }

    public function refresh(): JsonResponse
    {
        $token = auth('api')->refresh();

        return $this->success(
            'Token refreshed successfully',
            [
                'access_token' => $token,
                'token_type' => 'bearer',
            ]
        );
    }

    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return $this->success('Successfully logged out');
    }
}
