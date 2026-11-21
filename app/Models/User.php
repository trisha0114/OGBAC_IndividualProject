<?php

namespace App\Models;

use App\Models\Customer;
use App\Http\Filters\V1\QueryFilter;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Permissions\V1\Abilities;

#[Fillable(['name', 'email', 'password', 'is_manager'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the customers belonging to this user.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'user_id');
    }

    /**
     * Apply query filters to users/staff.
     */
    public function scopeFilter(
        Builder $builder,
        QueryFilter $filters
    ): Builder {
        return $filters->apply($builder);
    }

    /**
     * Get the JWT identifier.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Add custom claims to the JWT token.
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'abilities' => Abilities::getAbilities($this),
        ];
    }

    /**
     * Check whether the authenticated JWT has an ability.
     */
    public function tokenCan(string $ability): bool
    {
        try {
            $abilities = auth('api')->payload()->get('abilities');

            if (!is_array($abilities)) {
                return false;
            }

            return in_array($ability, $abilities, true);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_manager' => 'boolean',
        ];
    }
}
