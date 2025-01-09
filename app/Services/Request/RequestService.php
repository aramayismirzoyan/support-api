<?php

namespace App\Services\Request;

use App\Filters\Request\Data;
use App\Filters\Request\Status;
use App\Http\Requests\Api\GetRequestsRequest;
use App\Models\Request as RequestModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;

class RequestService
{
    public function getFiltered(GetRequestsRequest $request): Collection
    {
        $requestModel = RequestModel::query();

        $fields = ['id', 'status', 'message', 'answer', 'user_id', 'created_at'];

        $validated = $request->validated();

        return Pipeline::send($requestModel)
            ->through([
               new Data($validated),
               new Status($validated),
            ])
            ->thenReturn()
            ->select($fields)
            ->with('user', function ($query) {
                $query->select(['id', 'email']);
            })
            ->get();
    }

    public function create($message)
    {
        Auth::user()
            ->requests()
            ->create([
                'message' => $message,
            ]);
    }

    public function addAnswer($answer, $requestModel): void
    {
        $requestModel->status = RequestModel::RESOLVED;
        $requestModel->answer = $answer;
        $requestModel->save();
    }
}
