<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Impostazioni extends WorkInProgressPage
{
    protected static ?string $slug = 'impostazioni';

    protected static ?string $navigationLabel = 'Impostazioni';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 9;
}
