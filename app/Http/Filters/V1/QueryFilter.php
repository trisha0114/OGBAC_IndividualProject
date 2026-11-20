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

    // Columns that child filter classes may sort by.
    protected array $sortable = [];

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

    /**
     * ?sort=name
     * ?sort=-createdAt
     * ?sort=name,age
     */
    protected function sort($value): void
    {
        $sortAttributes = explode(',', $value);

        foreach ($sortAttributes as $sortAttribute) {
            $direction = 'asc';

            // A leading minus means descending order.
            if (str_starts_with($sortAttribute, '-')) {
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            // Ignore columns that are not in the whitelist.
            if (
                !in_array($sortAttribute, $this->sortable, true) &&
                !array_key_exists($sortAttribute, $this->sortable)
            ) {
                continue;
            }

            // Translate public names to actual database columns.
            $columnName = $this->sortable[$sortAttribute] ?? $sortAttribute;

            $this->builder->orderBy($columnName, $direction);
        }
    }
}
