<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_can_user_auth(): void
    {
        $user = createTestUser([
            'password' => 'test'
        ]);

        $response = $this->json('post', '/api/auth', [
            'email' => $user->email,
            'password' => 'test',
        ]);

        $response->assertStatus(200);
    }
}
