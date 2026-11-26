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

    public function getTitle(): string
    {
        return $this->getRecord()->full_name;
    }

    public function getSubheading(): ?string
    {
        return $this->getRecord()->trashed() ? 'Paziente archiviato' : null;
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Indietro')
                ->icon(Heroicon::ArrowLeft)
                ->link()
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
            Action::make('newSession')
                ->label('Nuova seduta')
                ->icon(Heroicon::OutlinedPlus)
                ->color('gray')
                ->url(fn () => TreatmentSessionResource::getUrl('create', ['patient' => $this->getRecord()->getKey()])),
            EditAction::make()->label('Modifica'),
        ];
    }
}
