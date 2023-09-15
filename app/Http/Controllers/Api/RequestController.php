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

class RequestController extends Controller
{
    public function getRequests(GetRequestsRequest $request)
    {
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
