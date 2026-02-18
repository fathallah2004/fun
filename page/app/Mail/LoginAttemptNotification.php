<?php

namespace App\Mail;

use App\Models\LoginAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginAttemptNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public LoginAttempt $attempt)
    {
    }

    public function build()
    {
        return $this->subject('Login Attempt Notification')
            ->view('emails.login-attempt')
            ->with([
                'attempt' => $this->attempt,
            ]);
    }
}
