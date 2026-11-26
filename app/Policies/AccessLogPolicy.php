<?php

namespace App\Policies;

use App\Models\AccessLog;
use App\Models\User;

/**
 * The audit trail can be read by physiotherapists and never changed.
 */
class AccessLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function view(User $user, AccessLog $accessLog): bool
    {
        return $user->isPhysiotherapist();
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, AccessLog $accessLog): bool
    {
        return false;
    }

    public function delete(User $user, AccessLog $accessLog): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }
}
