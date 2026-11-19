<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class APIController extends Controller
{
    /**
     * Returns true when the client requests a relationship
     * using the ?include=... query parameter.
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
}
