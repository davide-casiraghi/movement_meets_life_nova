<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class PrenotazioniOnline extends WorkInProgressPage
{
    protected static ?string $slug = 'prenotazioni-online';

    protected static ?string $navigationLabel = 'Prenotazioni online';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?int $navigationSort = 8;
}
