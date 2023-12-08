<?php

namespace App\Filters\Request;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RequestStatusFilter extends RequestFilterChain
{
    public function query(Builder $query, Request $request): Builder
    {
        if ($request->exists('status')) {
            $query = $query->ofStatus($request->status);
        }

        return $this->next($query, $request);
    }
}
