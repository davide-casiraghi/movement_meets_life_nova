<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum IdentityDocumentType: string implements HasLabel
{
    case IdentityCard = 'identity_card';
    case Passport = 'passport';
    case DrivingLicense = 'driving_license';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::IdentityCard => "Carta d'identità",
            self::Passport => 'Passaporto',
            self::DrivingLicense => 'Patente',
            self::Other => 'Altro',
        };
    }
}
