<?php

namespace App\Services\Request;

use App\Contracts\Request\MailServiceInterface;
use App\Models\Request;

class MailNullObjectService implements MailServiceInterface
{
    public function send(Request $request)
    {
        //
    }
}
