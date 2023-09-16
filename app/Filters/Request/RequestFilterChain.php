<?php

namespace App\Filters\Request;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class RequestFilterChain
{
    protected $filter;

    abstract public function query(Builder $query, Request $request): Builder;

    public function addFilter($filter)
    {
        $this->filter = $filter;
    }

    public function next(Builder $query, Request $request): Builder
    {
        if ($this->filter) {
            return $this->filter->query($query, $request);
        }

        return $query;
    }
}
