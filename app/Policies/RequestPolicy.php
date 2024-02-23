<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;

class RequestPolicy
{
    public function isAnswerResolved(User $user, Request $request): bool
    {
        return $request->status === Request::RESOLVED;
    }
}
