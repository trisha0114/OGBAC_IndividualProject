<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\UserFilter;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class StaffController extends APIController
{
    /**
     * Retrieve a paginated list of staff members.
     *
     * Supports filtering, sorting, and optional customer relationships.
     *
     * @group Staff Management
     *
     * @authenticated
     *
     * @queryParam include string Include related resources. Example: customers
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
     * Retrieve a specific staff member.
     *
     * Returns staff information and optionally associated customers.
     *
     * @group Staff Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the staff member. Example: 1
     *
     * @queryParam include string Include related resources. Example: customers
     */
    public function show(User $user)
    {
        if ($this->include('customers')) {
            $user->load('customers');
        }

        return new UserResource($user);
    }
}