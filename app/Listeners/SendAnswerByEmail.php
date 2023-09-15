<?php

namespace App\Listeners;

use App\Contracts\Request\MailServiceInterface;
use App\Events\RequestAnswered;

class SendAnswerByEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private MailServiceInterface $mail,
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RequestAnswered $event, ): void
    {
        $this->mail->send($event->requestModel);
    }
}
