<?php

namespace App\Filters\Request;

class RequestFilterFactory
{
    public static function make(): RequestFilterChain
    {
        $statusFilter = new RequestStatusFilter();
        $dataFilter = new RequestDataFilter();
        $statusFilter->addFilter($dataFilter);

        return $statusFilter;
    }
}
