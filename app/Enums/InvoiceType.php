<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum InvoiceType: string implements HasLabel
{
    case Health = 'health';
    case Electronic = 'electronic';
    case CreditNote = 'credit_note';

    public function getLabel(): string
    {
        return match ($this) {
            self::Health => 'Fattura sanitaria',
            self::Electronic => 'Fattura elettronica',
            self::CreditNote => 'Nota di credito',
        };
    }

    /** Credit notes reduce the turnover. */
    public function sign(): int
    {
        return $this === self::CreditNote ? -1 : 1;
    }
}
