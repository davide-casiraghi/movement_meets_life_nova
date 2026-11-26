<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

/**
 * Placeholder for a section of the physiotherapy panel whose features are not defined yet.
 * Each subclass only sets its menu label, icon, position and slug.
 */
abstract class WorkInProgressPage extends Page
{
    protected string $view = 'filament.pages.work-in-progress';

    public function getTitle(): string
    {
        return static::getNavigationLabel();
    }
}
