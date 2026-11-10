<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class StaffController extends Controller
{
    /**
     * GET /api/v1/staff
     * Returns all staff with their customers.
     */
    public function index()
    {
        return UserResource::collection(
            User::with('customers')->paginate(15)
        );
    }

    /**
     * GET /api/v1/staff/{user}
     * Returns one staff member with their customers.
     */
    public function show(User $user)
    {
        return new UserResource(
            $user->load('customers')
        );
    }
}
