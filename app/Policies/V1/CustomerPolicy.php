<?php

namespace App\Policies\V1;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any customers.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a customer.
     */
    public function view(User $user, Customer $customer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create customers.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update a customer.
     */
    public function update(User $user, Customer $customer): bool
    {
        return $user->id === $customer->user_id;
    }

    /**
     * Determine whether the user can delete a customer.
     */
    public function delete(User $user, Customer $customer): bool
    {
        return $user->id === $customer->user_id;
    }
}