<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/** "TipoRitenuta" of the Italian e-invoice (FatturaPA). */
enum WithholdingType: string implements HasLabel
{
    case Individuals = 'RT01';
    case Companies = 'RT02';
    case Inps = 'RT03';
    case Enasarco = 'RT04';
    case Enpam = 'RT05';
    case OtherFund = 'RT06';

    public function getLabel(): string
    {
        return match ($this) {
            self::Individuals => 'RT01 - Ritenuta persone fisiche',
            self::Companies => 'RT02 - Ritenuta persone giuridiche',
            self::Inps => 'RT03 - Contributo INPS',
            self::Enasarco => 'RT04 - Contributo ENASARCO',
            self::Enpam => 'RT05 - Contributo ENPAM',
            self::OtherFund => 'RT06 - Altro contributo previdenziale',
        };
    }
}
