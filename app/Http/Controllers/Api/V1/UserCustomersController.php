<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\CustomerFilter;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use App\Models\User;

class UserCustomersController extends APIController
{
    /**
     * GET /api/v1/users/{user}/customers
     * Lists only the customers belonging to one user.
     */
    public function index(User $user, CustomerFilter $filters)
    {
        return CustomerResource::collection(
            Customer::where('user_id', $user->id)
                ->filter($filters)
                ->paginate()
        );
    }
}