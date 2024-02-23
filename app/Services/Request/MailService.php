<?php

namespace App\Services\Request;

use App\Contracts\Request\MailServiceInterface;
use App\Mail\RequestAnswered;
use App\Models\Request;
use Illuminate\Support\Facades\Mail;

class MailService implements MailServiceInterface
{
    public function send(Request $request): void
    {
        Mail::to($request->user->email)
            ->send(new RequestAnswered([
                'title' => 'Ответ на вашу заявку',
                'body' => $request->answer,
            ]));
    }
}
