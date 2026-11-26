<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

/**
 * Health data: only physiotherapists, admins of the website included only if they have that role.
 */
class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function view(User $user, Patient $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function create(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function update(User $user, Patient $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function delete(User $user, Patient $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function restore(User $user, Patient $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function restoreAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function forceDelete(User $user, Patient $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }
}
