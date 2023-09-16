<?php

namespace Tests\Feature\Traits;

use App\Models\User;

trait UserAuth
{
    public function getAuthToken($userData = [])
    {
        $user = createTestUser($userData);

        $this->actingAs($user);

        return 'Bearer '.User::getToken($user->email);
    }
}
