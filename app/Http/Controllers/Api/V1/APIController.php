<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class APIController extends Controller
{
    use ApiResponses, AuthorizesRequests;

    /**
     * Returns true when the client asked for a relationship
     * with ?include=...
     */
    public function include(string $relationship): bool
    {
        $param = request()->get('include');

        if (!isset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }

    /**
     * Checks if the logged-in user is authorized.
     * Returns true if allowed, false if denied.
     */
    public function isAble(string $ability, mixed $target): bool
    {
        try {
            $this->authorize($ability, $target);

            return true;
        } catch (AuthorizationException $e) {
            return false;
        }
    }
}
