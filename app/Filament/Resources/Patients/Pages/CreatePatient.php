<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected static ?string $title = 'Nuovo paziente';

    public static string|Alignment $formActionsAlignment = Alignment::Between;

    public function getSubheading(): string
    {
        return 'Raccogli tutte le informazioni principali del paziente.';
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
        ];
    }

    /** "← Torna ai pazienti" on the left, "Crea nuovo paziente" on the right. */
    protected function getFormActions(): array
    {
        return [
            $this->getCancelFormAction()
                ->label('Torna ai pazienti')
                ->icon(Heroicon::ArrowLeft)
                ->link()
                ->color('gray'),
            $this->getCreateFormAction()->label('Crea nuovo paziente'),
        ];
    }

    protected function getCreatedNotificationTitle(): string
    {
        return 'Paziente creato';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
