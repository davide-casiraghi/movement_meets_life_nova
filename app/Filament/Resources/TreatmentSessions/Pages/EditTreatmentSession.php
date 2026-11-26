<?php

namespace App\Filament\Resources\TreatmentSessions\Pages;

use App\Filament\Concerns\LogsRecordView;
use App\Filament\Resources\TreatmentSessions\TreatmentSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTreatmentSession extends EditRecord
{
    use LogsRecordView;

    protected static string $resource = TreatmentSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
