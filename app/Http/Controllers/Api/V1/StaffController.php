<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\UserFilter;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class StaffController extends APIController
{
    /**
     * GET /api/v1/staff
     * Supports sorting and optional customer relationships.
     */
    public function index(UserFilter $filters)
    {
        $users = User::filter($filters);

        if ($this->include('customers')) {
            $users->with('customers');
        }

        return UserResource::collection(
            $users->paginate(15)
        );
    }

    /**
     * GET /api/v1/staff/{user}
     */
    public function show(User $user)
    {
        if ($this->include('customers')) {
            $user->load('customers');
        }

        return new UserResource($user);
    }
}
