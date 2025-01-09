<?php

namespace App\Filters\Request;

use Illuminate\Database\Eloquent\Builder;

class Data extends Filter
{
    public function handle(Builder $builder, \Closure $next)
    {
        $builder->when($this->data['created_at'] ?? null, function ($query, $data) {
            $query->where(function ($query) use ($data) {
                $query->whereDate('created_at', '=', $data);
                $query->orWhere('created_at', '=', $data);
            });
        });

        return $next($builder);
    }
}
