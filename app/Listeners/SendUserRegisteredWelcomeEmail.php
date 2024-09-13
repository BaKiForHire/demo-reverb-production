<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

/**
 * Listener for sending a welcome email when a user registers.
 */
class SendUserRegisteredWelcomeEmail
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        // Send welcome email to the newly registered user
        Mail::to($event->user->email)->send(new WelcomeMail($event->user));
    }
}
