<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\ContactMeMailNotification;
use App\Notifications\GetATreatmentMailNotification;

class NotificationService
{

    /**
     * Send an email when the contact form is submitted
     *
     * @param array $data
     * @param int $userId
     *
     * @return bool
     */
    public function sendEmailContactMe(array $data, int $userId): bool
    {
        $user = User::find($userId);
        $user->notify(new ContactMeMailNotification($data));

        return true;
    }

    /**
     * Send an email when the get a treatment form is submitted
     *
     * @param array $data
     * @param int $userId
     *
     * @return bool
     */
    public function sendEmailGetATreatment(array $data, int $userId): bool
    {
        $user = User::find($userId);
        $user->notify(new GetATreatmentMailNotification($data));

        return true;
    }

}
