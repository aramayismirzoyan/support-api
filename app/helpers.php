<?php

use App\Models\Request;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

if (!function_exists('createTestUser')) {
    function createTestUser($data = [])
    {
        return User::factory()->create($data);
    }
}

if (!function_exists('createRequest')) {
    function createRequest($data = [])
    {
        return Request::factory()->for(Auth::user())->create($data);
    }
}

if (!function_exists('createForbiddenResponse')) {
    function createForbiddenResponse(string $message = ''): \Illuminate\Http\JsonResponse
    {
        $response = ['success' => false];

        if ($message !== '') {
            $response['message'] = $message;
        }

        return response()->json($response, 403);
    }
}

if (!function_exists('createSuccessResponse')) {
    function createSuccessResponse(string $message = ''): \Illuminate\Http\JsonResponse
    {
        $response = ['success' => true];

        if ($message !== '') {
            $response['message'] = $message;
        }

        return response()->json($response);
    }
}

if (!function_exists('throwForbiddenResponseException')) {
    function throwForbiddenResponseException(string $message = ''): void
    {
        $response = createForbiddenResponse($message);

        throw new HttpResponseException($response);
    }
}
