<?php

namespace App\Permissions\V1;

use App\Models\User;

/**
 * Central list of API token abilities.
 *
 * Format: resource:action
 * "own" means the user can only access their own records.
 */
final class Abilities
{
    // Customer abilities
    public const CreateCustomer = 'customer:create';
    public const CreateOwnCustomer = 'customer:own:create';

    public const UpdateCustomer = 'customer:update';
    public const UpdateOwnCustomer = 'customer:own:update';

    public const ReplaceCustomer = 'customer:replace';

    public const DeleteCustomer = 'customer:delete';
    public const DeleteOwnCustomer = 'customer:own:delete';

    // User management abilities (managers only)
    public const CreateUser = 'user:create';
    public const UpdateUser = 'user:update';
    public const ReplaceUser = 'user:replace';
    public const DeleteUser = 'user:delete';

    /**
     * Return the abilities assigned to a user.
     */
    public static function getAbilities(User $user): array
    {
        // Managers can perform all actions.
        if ($user->is_manager) {
            return [
                self::CreateCustomer,
                self::UpdateCustomer,
                self::ReplaceCustomer,
                self::DeleteCustomer,

                self::CreateUser,
                self::UpdateUser,
                self::ReplaceUser,
                self::DeleteUser,
            ];
        }

        // Regular users can only manage their own customers.
        return [
            self::CreateOwnCustomer,
            self::UpdateOwnCustomer,
            self::DeleteOwnCustomer,
        ];
    }
}