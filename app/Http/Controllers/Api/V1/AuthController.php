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

    /**
     * Register a new user account.
     *
     * Creates a new user and automatically generates
     * a JWT access token.
     *
     * @group Authentication
     *
     * @unauthenticated
     */
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

    /**
     * Authenticate a user and generate an access token.
     *
     * Validates the user's email and password.
     *
     * @group Authentication
     *
     * @unauthenticated
     */
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

    /**
     * Retrieve the currently authenticated user.
     *
     * Returns the user information associated with
     * the supplied JWT access token.
     *
     * @group Authentication
     *
     * @authenticated
     */
    public function me(): JsonResponse
    {
        return $this->success(
            'User retrieved successfully',
            auth('api')->user()
        );
    }

    /**
     * Refresh the current JWT access token.
     *
     * Generates a new access token for the authenticated user.
     *
     * @group Authentication
     *
     * @authenticated
     */
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

    /**
     * Log out the currently authenticated user.
     *
     * Invalidates the current JWT access token.
     *
     * @group Authentication
     *
     * @authenticated
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return $this->success('Successfully logged out');
    }
}
