<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RepresentativeRole: string implements HasLabel
{
    case Parent = 'parent';
    case Guardian = 'guardian';
    case Curator = 'curator';
    case SupportAdministrator = 'support_administrator';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Parent => 'Genitore',
            self::Guardian => 'Tutore',
            self::Curator => 'Curatore',
            self::SupportAdministrator => 'Amministratore di sostegno',
            self::Other => 'Altro',
        };
    }
}
