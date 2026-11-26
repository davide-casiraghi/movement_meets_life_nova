<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class ListinoPrezzi extends WorkInProgressPage
{
    protected static ?string $slug = 'listino-prezzi';

    protected static ?string $navigationLabel = 'Listino prezzi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?int $navigationSort = 7;
}
