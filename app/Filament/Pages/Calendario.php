<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Calendario extends WorkInProgressPage
{
    protected static ?string $slug = 'calendario';

    protected static ?string $navigationLabel = 'Calendario';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?int $navigationSort = 1;
}
