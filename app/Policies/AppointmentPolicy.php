<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

/**
 * Health data: only physiotherapists, admins of the website included only if they have that role.
 */
class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function view(User $user, Appointment $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function create(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function update(User $user, Appointment $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function delete(User $user, Appointment $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function restore(User $user, Appointment $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function restoreAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function forceDelete(User $user, Appointment $record): bool
    {
        return $user->isPhysiotherapist();
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }
}
