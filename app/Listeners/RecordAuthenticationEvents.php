<?php

namespace App\Listeners;

use App\Models\AccessLog;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;

/**
 * Writes logins, failed logins and logouts into the access log.
 */
class RecordAuthenticationEvents
{
    public function handleLogin(Login $event): void
    {
        AccessLog::record('login', userId: $event->user->getAuthIdentifier());
    }

    public function handleFailed(Failed $event): void
    {
        AccessLog::record(
            'login_failed',
            properties: ['email' => $event->credentials['email'] ?? null],
            userId: $event->user?->getAuthIdentifier(),
        );
    }

    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            AccessLog::record('logout', userId: $event->user->getAuthIdentifier());
        }
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleLogin',
            Failed::class => 'handleFailed',
            Logout::class => 'handleLogout',
        ];
    }
}
