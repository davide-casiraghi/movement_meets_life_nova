<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\ContactMeMailNotification;

class NotificationService
{

    /**
     * Send an email when the contact form is submitted
     *
     * @param array $data
     *
     * @return bool
     */
    public function sendEmailContactMe(array $data): bool
    {
        $admin = User::find(1);
        $admin->notify(new ContactMeMailNotification($data));

        return true;
    }

}
