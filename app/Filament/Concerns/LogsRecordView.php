<?php

namespace App\Filament\Concerns;

/**
 * For View and Edit pages of records holding health data: opening the page
 * shows the clinical fields, so it is written to the access log.
 */
trait LogsRecordView
{
    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->getRecord()->logView();
    }
}
