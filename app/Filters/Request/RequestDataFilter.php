<?php

namespace App\Filters\Request;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RequestDataFilter extends RequestFilterChain
{
    public function query(Builder $query, Request $request): Builder
    {
        if ($request->exists('created_at')) {
            $query = $query
                ->ofData($request->created_at);
        }

        return $this->next($query, $request);
    }
}
