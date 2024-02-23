<?php

namespace App\Services\Request;

use App\Filters\Request\RequestFilterFactory;
use App\Models\Request as RequestModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestService
{
    public function getFiltered(Request $request): Collection
    {
        $requestModel = RequestModel::query();
        $filter = RequestFilterFactory::make();

        $fields = ['id', 'status', 'message', 'answer', 'user_id', 'created_at'];

        return $filter
            ->query($requestModel, $request)
            ->select($fields)
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
