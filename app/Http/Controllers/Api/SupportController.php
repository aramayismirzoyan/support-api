<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;

class SupportController extends Controller
{
    public function getRequests()
    {
        $requests = RequestModel::all();
        return $requests;
    }
}
