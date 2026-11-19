<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Base class for every filter.
 * Converts query parameters into query conditions.
 */
abstract class QueryFilter
{
    protected Builder $builder;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (
                $key !== 'apply' &&
                !str_starts_with($key, '_') &&
                method_exists($this, $key)
            ) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }
}
