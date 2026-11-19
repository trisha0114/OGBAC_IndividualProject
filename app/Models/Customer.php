<?php

namespace App\Models;

use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'contact_number',
        'address',
        'user_id',
    ];

    /**
     * Relationship: Customer belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Apply filters to the Customer query.
     */
    public function scopeFilter(
        Builder $builder,
        QueryFilter $filters
    ): Builder {
        return $filters->apply($builder);
    }
}
