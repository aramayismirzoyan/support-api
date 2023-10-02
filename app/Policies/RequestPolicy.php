<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestPolicy
{
    public function isAnswerResolved(User $user, Request $request): bool
    {
        return $request->status === Request::RESOLVED;
    }
}
