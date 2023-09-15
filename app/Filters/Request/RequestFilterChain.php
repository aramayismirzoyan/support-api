<?php

namespace App\Filters\Request;

use App\Models\Request as RequestModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class RequestFilterChain
{
    protected $filter;
    abstract public function query(Builder $query, Request $request);

    public function addFilter($filter)
    {
        $this->filter = $filter;
    }

    public function next(Builder $query, Request $request)
    {
        if($this->filter) {
            return $this->filter->query($query, $request);
        }

        return $query;
    }
}