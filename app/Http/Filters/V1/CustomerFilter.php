<?php

namespace App\Http\Filters\V1;

class CustomerFilter extends QueryFilter
{
    /**
     * ?createdAt=2026-11-19
     * ?createdAt=2026-11-01,2026-11-30
     */
    public function createdAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    /**
     * ?updatedAt=2026-11-19
     * ?updatedAt=2026-11-01,2026-11-30
     */
    public function updatedAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }

    /**
     * ?user=1
     * ?user=1,2
     */
    public function user($value)
    {
        return $this->builder->whereIn('user_id', explode(',', $value));
    }

    /**
     * ?age=18
     * ?age=18,25
     */
    public function age($value)
    {
        return $this->builder->whereIn('age', explode(',', $value));
    }

    /**
     * ?name=*John*
     * The * wildcard becomes SQL % for LIKE search.
     */
    public function name($value)
    {
        $likeStr = str_replace('*', '%', $value);

        return $this->builder->where('name', 'like', $likeStr);
    }
}
