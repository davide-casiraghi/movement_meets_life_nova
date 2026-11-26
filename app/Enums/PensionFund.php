<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/** Pension fund of the practitioner, for the "rivalsa / contributo integrativo". */
enum PensionFund: string implements HasLabel
{
    case Enpam = 'enpam';
    case Enpap = 'enpap';
    case Enpab = 'enpab';
    case Enpav = 'enpav';
    case Enpaf = 'enpaf';
    case Enpapi = 'enpapi';
    case Epap = 'epap';
    case InpsSeparate = 'inps_separate';
    case InpsTraders = 'inps_traders';

    public function getLabel(): string
    {
        return match ($this) {
            self::Enpam => 'ENPAM - Ente Nazionale di Previdenza ed Assistenza dei Medici e degli Odontoiatri',
            self::Enpap => 'ENPAP - Ente Nazionale di Previdenza e Assistenza per gli Psicologi',
            self::Enpab => 'ENPAB - Ente Nazionale di Previdenza e Assistenza dei Biologi',
            self::Enpav => 'ENPAV - Ente Nazionale di Previdenza ed Assistenza dei Veterinari',
            self::Enpaf => 'ENPAF - Ente Nazionale di Previdenza e Assistenza dei Farmacisti',
            self::Enpapi => 'ENPAPI - Ente Nazionale di Previdenza e Assistenza della Professione Infermieristica',
            self::Epap => 'EPAP - Ente di Previdenza e Assistenza Pluricategoriale',
            self::InpsSeparate => 'Gestione Separata INPS',
            self::InpsTraders => 'INPS COMMERCIANTI - INPS Artigiani/Commercianti',
        };
    }

    /**
     * The 4% "rivalsa" of the INPS separate scheme is part of the fee, so the
     * withholding tax applies to it too; the "contributo integrativo" of the
     * professional funds is not.
     */
    public function isSubjectToWithholding(): bool
    {
        return $this === self::InpsSeparate;
    }
}
