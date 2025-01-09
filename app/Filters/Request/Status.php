<?php

namespace App\Filters\Request;

use Illuminate\Database\Eloquent\Builder;

class Status extends Filter
{
    public function handle(Builder $builder, \Closure $next)
    {
        $builder->when($this->data['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });

        return $next($builder);
    }
}
