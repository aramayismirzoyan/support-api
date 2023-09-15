<?php

namespace App\Contracts\Request;

use App\Models\Request;

interface MailServiceInterface
{
    public function send(Request $request);
}
