<?php

namespace Tests\Feature;

use App\Models\Request;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\Traits\UserAuth;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use RefreshDatabase;
    use UserAuth;

    public function test_not_support_user_cannt_get_requests(): void
    {
        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $this->getAuthToken(),
        ])->json('get', '/api/requests');

        $response->assertStatus(403);
    }

    public function test_can_support_user_get_requests_without_filter(): void
    {
        $token = $this->getAuthToken(['is_support' => true]);

        Request::factory()->for(Auth::user())->count(2)->create();

        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $token,
        ])->json('get', '/api/requests');

        $response->assertJsonCount(2);
        $response->assertStatus(200);
    }

    public function test_can_support_user_get_requests_filter_by_status(): void
    {
        $token = $this->getAuthToken(['is_support' => true]);

        Request::factory()
            ->for(Auth::user())
            ->count(2)
            ->create();

        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $token,
        ])->json('get', '/api/requests', [
            'status' => 'active',
        ]);

        $response->assertJsonCount(2);
        $response->assertStatus(200);
    }

    public function test_can_support_user_get_requests_filter_by_data(): void
    {
        $token = $this->getAuthToken(['is_support' => true]);

        $yesterday = Carbon::yesterday()->toDateTimeString();
        $now = Carbon::now()->toDateTimeString();

        createRequest(['created_at' => $yesterday]);
        createRequest(['created_at' => $now]);

        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $token,
        ])->json('get', '/api/requests', [
            'created_at' => $now,
        ]);

        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    public function test_can_support_user_get_requests_filter_by_status_and_data(): void
    {
        $token = $this->getAuthToken(['is_support' => true]);

        $now = Carbon::now()->toDateTimeString();

        createRequest([
            'status' => 'active',
            'created_at' => $now,
        ]);
        createRequest([
            'status' => 'resolved',
            'created_at' => $now,
        ]);

        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $token,
        ])->json('get', '/api/requests', [
            'status' => 'active',
            'created_at' => $now,
        ]);

        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    public function test_can_user_add_request(): void
    {
        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $this->getAuthToken(),
        ])->json('post', '/api/requests', [
            'message' => 'Some text for message',
        ]);

        $response->assertStatus(200);

        $request = Request::first();

        $this->assertEquals('Some text for message', $request->message);
        $this->assertEquals(1, Request::count());
    }

    public function test_no_support_user_cannt__add_answer(): void
    {
        $token = $this->getAuthToken();

        $request = createRequest();

        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $token,
        ])->json('put', '/api/requests/' . $request->id, [
            'answer' => 'Some text for answer',
        ]);

        $response->assertStatus(403);
    }

    public function test_support_user_cannt_add_answer_second_time(): void
    {
        $token = $this->getAuthToken(['is_support' => true]);

        $request = createRequest([
            'status' => 'resolved',
            'answer' => 'Some text for answer',
        ]);

        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $token,
        ])->json('put', '/api/requests/' . $request->id, [
            'answer' => 'Some text for answer',
        ]);

        $response->assertStatus(403);
    }

    public function test_can_support_user_add_answer(): void
    {
        $token = $this->getAuthToken(['is_support' => true]);

        $request = createRequest();

        $response = $this->withHeaders([
            'Accept', 'application/json',
            'Authorization', $token,
        ])->json('put', '/api/requests/' . $request->id, [
            'answer' => 'Some text for answer',
        ]);

        $response->assertStatus(200);

        $answeredRequest = Request::first();

        $this->assertEquals('Some text for answer', $answeredRequest->answer);
        $this->assertEquals('resolved', $answeredRequest->status);
    }
}
