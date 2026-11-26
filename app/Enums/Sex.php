<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Sex: string implements HasLabel
{
    case Male = 'M';
    case Female = 'F';
    // "X", as on documents when the sex is neither M nor F (the column holds one character).
    case Other = 'X';

    public function getLabel(): string
    {
        return match ($this) {
            self::Male => 'Uomo',
            self::Female => 'Donna',
            self::Other => 'Altro',
        };
    }
}
