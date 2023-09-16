<?php

use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('createTestUser')) {
    function createTestUser($data = []) {
        return User::factory()->create($data);
    }
}

if (! function_exists('createRequest')) {
    function createRequest($data = []) {
        return Request::factory()->for(Auth::user())->create($data);
    }
}

