<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

/** Invoices show treatments of patients: physiotherapists only, like the clinical data. */
class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $user->isPhysiotherapist();
    }

    public function create(User $user): bool
    {
        return $user->isPhysiotherapist();
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->isPhysiotherapist();
    }

    /** Issued invoices are never deleted: a credit note cancels them. */
    public function delete(User $user, Invoice $invoice): bool
    {
        return false;
    }
}
