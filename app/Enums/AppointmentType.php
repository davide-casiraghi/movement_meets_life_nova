<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AppointmentType: string implements HasLabel
{
    case Work = 'work';
    case Holiday = 'holiday';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Work => 'Lavoro',
            self::Holiday => 'Ferie',
            self::Other => 'Altro',
        };
    }
}
