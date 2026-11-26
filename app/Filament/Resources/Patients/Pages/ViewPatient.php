<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Concerns\LogsRecordView;
use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\TreatmentSessions\TreatmentSessionResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewPatient extends ViewRecord
{
    use LogsRecordView;

    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('newSession')
                ->label('Nuova seduta')
                ->icon(Heroicon::OutlinedPlus)
                ->url(fn () => TreatmentSessionResource::getUrl('create', ['patient' => $this->getRecord()->getKey()])),
            EditAction::make(),
        ];
    }
}
