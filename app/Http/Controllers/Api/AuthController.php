<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private function isAuthorized($email, $password)
    {
        $authData = [
            'email' => $email,
            'password' => $password
        ];

        return Auth::attempt($authData);
    }
    public function generateToken(LoginRequest $request)
    {
        if($this->isAuthorized($request->email, $request->password)) {
            $token = Auth::user()
                ->createToken($request->email)
                ->plainTextToken;

            return response()
                ->json(compact('token'));
        }
    }
}
