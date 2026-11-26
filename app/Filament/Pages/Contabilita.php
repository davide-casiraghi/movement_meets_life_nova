<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Contabilita extends WorkInProgressPage
{
    protected static ?string $slug = 'contabilita';

    protected static ?string $navigationLabel = 'Contabilità';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?int $navigationSort = 3;
}
