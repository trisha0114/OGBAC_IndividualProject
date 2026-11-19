<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\UserResource;
use App\Models\User;

class StaffController extends APIController
{
    /**
     * GET /api/v1/staff
     */
    public function index()
    {
        if ($this->include('customers')) {
            return UserResource::collection(
                User::with('customers')->paginate(15)
            );
        }

        return UserResource::collection(
            User::paginate(15)
        );
    }

    /**
     * GET /api/v1/staff/{user}
     */
    public function show(User $user)
    {
        if ($this->include('customers')) {
            return new UserResource(
                $user->load('customers')
            );
        }

        return new UserResource($user);
    }
}
