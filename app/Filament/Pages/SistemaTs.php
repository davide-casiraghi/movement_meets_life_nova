<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class SistemaTs extends WorkInProgressPage
{
    protected static ?string $slug = 'sistema-ts';

    protected static ?string $navigationLabel = 'Sistema TS';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPath;

    protected static ?int $navigationSort = 4;
}
