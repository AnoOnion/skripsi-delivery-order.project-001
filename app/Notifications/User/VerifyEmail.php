<?php

namespace App\Notifications\User;

use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail as Notification;

use Carbon\Carbon;

class VerifyEmail extends Notification
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), [
                'user' => $notifiable->id,
                'hash' => sha1($notifiable->getEmailForVerification())
            ]
        );

        return str_replace('/api/user', '', $url);
    }
}
