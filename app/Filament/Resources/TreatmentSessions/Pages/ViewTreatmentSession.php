<?php

namespace App\Filament\Resources\TreatmentSessions\Pages;

use App\Filament\Concerns\LogsRecordView;
use App\Filament\Resources\TreatmentSessions\TreatmentSessionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTreatmentSession extends ViewRecord
{
    use LogsRecordView;

    protected static string $resource = TreatmentSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
