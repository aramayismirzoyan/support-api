<?php

namespace App\Http\Controllers\Api;

use App\Events\RequestAnswered;
use App\Filters\Request\RequestDataFilter;
use App\Filters\Request\RequestStatusFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddAnswerRequest;
use App\Http\Requests\Api\GetRequestsRequest;
use App\Http\Requests\Api\StoreRequestRequest;
use App\Http\Resources\RequestResource;
use App\Models\Request as RequestModel;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Gate;

class RequestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/requests",
     *     summary="Получение списка заявок для ответственного лица",
     *     tags={"Request"},
     *     security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Состояние заявки",
     *         required=false,
     *         example="active",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="created_at",
     *         in="query",
     *         description="Дата создания",
     *         required=false,
     *         example="2023-09-15",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Возвращает список",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="1"
     *               ),
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="active"
     *               ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Какой-то текст"
     *               ),
     *              @OA\Property(
     *                  property="answer",
     *                  type="string",
     *                  example="Какой-то ответ"
     *               ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="user@test.com"
     *               ),
     *              @OA\Property(
     *                  property="created",
     *                  type="string",
     *                  example="6 minutes ago"
     *               ),
     *          )
     *      ),
     *     @OA\Response(response="403", description="Доступ запрещен")
     * )
     */
    public function getRequests(GetRequestsRequest $request)
    {
        if(!Gate::allows('isSupport', Auth::user())) {
            return response()->json([], 403);
        }

        $query = RequestModel::query();
        $statusFilter = new RequestStatusFilter();
        $dataFilter = new RequestDataFilter();

        $statusFilter->addFilter($dataFilter);
        $requests = $statusFilter->query($query, $request)
            ->get([
                'id', 'status', 'message', 'answer', 'user_id', 'created_at',
            ]);

        return RequestResource::collection($requests);
    }

    /**
     * @OA\Post(
     *     path="/api/requests",
     *     summary="Добавление заявки",
     *     tags={"Request"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *             oneOf={
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="message",
     *                          type="string",
     *                          example="Какой-то текст"
     *                      ),
     *                  ),
     *             },
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Успешное добавление заявки",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=true
     *               ),
     *          )
     *      )
     * )
     */
    public function store(StoreRequestRequest $request)
    {
        Auth::user()
            ->requests()
            ->create([
                'message' => $request->message
            ]);

        return response()
            ->json(['success' => true]);
    }

    /**
     * @OA\Put(
     *     path="/api/requests/{request}",
     *     summary="Добавление заявки",
     *     tags={"Request"},
     *     security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *         in="path",
     *         description="ID заявки",
     *         name="request",
     *         required=true,
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *             oneOf={
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="answer",
     *                          type="string",
     *                          example="Какой-то текст"
     *                      ),
     *                  ),
     *             },
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Успешное добавление заявки",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=true
     *               ),
     *          )
     *      ),
     *      @OA\Response(response="403", description="Доступ запрещен")
     * )
     */
    public function addAnswer(RequestModel $request, AddAnswerRequest $requestInput)
    {
        try {
            $request->addAnswer($requestInput->answer);
        } catch (Exception $e) {
            return response()->json([
                'success' => false
            ], 403);
        }

        RequestAnswered::dispatch($request);

        return response()->json([
            'success' => true
        ]);
    }
}
