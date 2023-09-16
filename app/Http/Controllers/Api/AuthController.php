<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *    title="Support API",
 *    version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer"
 * )
 */
class AuthController extends Controller
{
    private function isAuthorized($email, $password): bool
    {
        $authData = [
            'email' => $email,
            'password' => $password
        ];

        return Auth::attempt($authData);
    }

    /**
     * @OA\Post(
     *     path="/api/auth",
     *     summary="Генерация токена для аутентификации пользователя",
     *     tags={"Auth"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *             oneOf={
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="email",
     *                          type="string",
     *                          example="support@test.com"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string",
     *                          example="support"
     *                      ),
     *                  ),
     *             },
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Успешная аутентификация",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="token",
     *                  type="string",
     *                  example="some token"
     *               ),
     *          )
     *      ),
     *     @OA\Response(response="403", description="Доступ запрещен")
     * )
     */
    public function generateToken(LoginRequest $request): JsonResponse
    {
        if ($this->isAuthorized($request->email, $request->password)) {
            $token = User::getToken($request->email);

            return response()
                ->json(compact('token'));
        }

        return response()
            ->json([
                'auth' => false
            ], 403);
    }
}
