<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'manager@pooldesk.com'],
            [
                'name' => 'PoolDesk Manager',
                'password' => 'Manager2026!',
                'is_manager' => true,
            ]
        );
    }
}
