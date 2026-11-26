<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AppointmentStatus: string implements HasLabel
{
    case Scheduled = 'scheduled';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case NoShow = 'no_show';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Scheduled => 'Programmato',
            self::Confirmed => 'Confermato',
            self::Completed => 'Completato',
            self::NoShow => 'Non presentato',
            self::Cancelled => 'Annullato',
        };
    }

    /** A cancelled appointment frees its time slot. */
    public function blocksTime(): bool
    {
        return $this !== self::Cancelled;
    }
}
