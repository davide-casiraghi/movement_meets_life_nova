<?php

namespace App\Filament\Concerns;

/**
 * Edit pages fill the form with $record->attributesToArray(), which leaves out the
 * attributes listed in the model's $hidden: here, the encrypted clinical fields.
 * Without this the form would open with those fields empty and saving would erase them.
 */
trait FillsHiddenAttributes
{
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        return [...$data, ...$record->only($record->getHidden())];
    }
}
