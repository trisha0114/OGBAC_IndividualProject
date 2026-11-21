<?php

namespace App\Policies\V1;

use App\Models\Customer;
use App\Models\User;
use App\Permissions\V1\Abilities;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Customer $customer): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->tokenCan(Abilities::CreateCustomer)
            || $user->tokenCan(Abilities::CreateOwnCustomer);
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->tokenCan(Abilities::UpdateCustomer)
            || (
                $user->tokenCan(Abilities::UpdateOwnCustomer)
                && $user->id === $customer->user_id
            );
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->tokenCan(Abilities::DeleteCustomer)
            || (
                $user->tokenCan(Abilities::DeleteOwnCustomer)
                && $user->id === $customer->user_id
            );
    }
}
