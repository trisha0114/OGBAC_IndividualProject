<?php

namespace App\Http\Filters\V1;

class UserFilter extends QueryFilter
{
    // Allowed columns for sorting users/staff.
    protected array $sortable = [
        'name',
        'email',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];
}
