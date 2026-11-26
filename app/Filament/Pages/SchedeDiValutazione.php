<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class SchedeDiValutazione extends WorkInProgressPage
{
    protected static ?string $slug = 'schede-di-valutazione';

    protected static ?string $navigationLabel = 'Schede di valutazione';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static ?int $navigationSort = 6;
}
