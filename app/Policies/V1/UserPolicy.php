<?php

namespace App\Policies\V1;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('user:create');
    }

    public function view(User $user, User $model): bool
    {
        return $user->tokenCan('user:update');
    }

    public function create(User $user): bool
    {
        return $user->tokenCan('user:create');
    }

    public function update(User $user, User $model): bool
    {
        return $user->tokenCan('user:update');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->tokenCan('user:delete');
    }
}