<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Modulistica extends WorkInProgressPage
{
    protected static ?string $slug = 'modulistica';

    protected static ?string $navigationLabel = 'Modulistica';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?int $navigationSort = 5;
}
