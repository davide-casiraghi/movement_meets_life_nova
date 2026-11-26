<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

class ManageServices extends ManageRecords
{
    protected static string $resource = ServiceResource::class;

    protected static ?string $title = 'Listino prezzi';

    protected ?string $subheading = 'I servizi del tuo studio, con durata e prezzo';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuovo servizio')
                ->icon(Heroicon::Plus)
                ->modalHeading('Nuovo servizio')
                ->modalSubmitActionLabel('Crea servizio')
                ->createAnother(false)
                ->successNotificationTitle('Servizio creato'),
        ];
    }
}
