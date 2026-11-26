<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use App\Models\Patient;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\Url;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected static ?string $title = 'Pazienti';

    /** "Tutti" / "Attivi" / "Archiviati": select next to the search field (patients-status-filter view). */
    #[Url]
    public string $status = 'all';

    public function updatedStatus(): void
    {
        if (! in_array($this->status, ['all', 'active', 'archived'], true)) {
            $this->status = 'all';
        }

        $this->resetPage($this->getTablePaginationPageName());
    }

    public function getSubheading(): string
    {
        return '#'.Patient::count().' Totale pazienti';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Aggiungi paziente'),
        ];
    }
}
