<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Concerns\FillsHiddenAttributes;
use App\Filament\Concerns\LogsRecordView;
use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;

class EditPatient extends EditRecord
{
    use FillsHiddenAttributes;
    use LogsRecordView;

    protected static string $resource = PatientResource::class;

    public static string|Alignment $formActionsAlignment = Alignment::Between;

    public function getTitle(): string
    {
        return 'Modifica paziente';
    }

    public function getSubheading(): string
    {
        return $this->getRecord()->full_name;
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    /** The sessions list stays on the patient page only. */
    public function getRelationManagers(): array
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
                ->url($this->getResource()::getUrl('view', ['record' => $this->getRecord()])),
            DeleteAction::make()
                ->label('Archivia')
                ->icon(Heroicon::OutlinedArchiveBox)
                ->color('gray')
                ->modalHeading('Archiviare il paziente?')
                ->modalDescription('Non comparirà più tra i pazienti attivi. La scheda e le sedute restano conservate e puoi ripristinarlo quando vuoi.')
                ->modalSubmitActionLabel('Archivia')
                ->successNotificationTitle('Paziente archiviato'),
            RestoreAction::make()->label('Ripristina'),
            ForceDeleteAction::make()
                ->label('Elimina definitivamente')
                ->modalDescription('Il paziente, le sue sedute e i rappresentanti verranno cancellati per sempre. Non si può annullare.'),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCancelFormAction()
                ->label('Torna al paziente')
                ->icon(Heroicon::ArrowLeft)
                ->link()
                ->color('gray'),
            $this->getSaveFormAction()->label('Salva modifiche'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
