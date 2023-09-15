<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function isSupport(User $user)
    {
        return $user->is_support === true;
    }
}
