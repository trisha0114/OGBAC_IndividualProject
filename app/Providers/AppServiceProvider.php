<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Customer;
use App\Models\User;
use App\Policies\V1\CustomerPolicy;
use App\Policies\V1\UserPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register Customer model with CustomerPolicy
        Gate::policy(Customer::class, CustomerPolicy::class);

        // Register User model with UserPolicy
        Gate::policy(User::class, UserPolicy::class);
    }
}
