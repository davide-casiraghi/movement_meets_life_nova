<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Filament\Resources\TreatmentSessions\TreatmentSessionResource;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * Lists the sessions of a patient (date and duration only). The clinical
 * content opens on the session pages, so every reading is logged there.
 */
class TreatmentSessionsRelationManager extends RelationManager
{
    protected static string $relationship = 'treatmentSessions';

    protected static ?string $title = 'Sedute';

    protected static ?string $modelLabel = 'seduta';

    protected static ?string $pluralModelLabel = 'sedute';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('performed_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('duration_minutes')->label('Durata')->suffix(' min')->placeholder('—'),
            ])
            ->defaultSort('performed_at', 'desc')
            ->recordUrl(fn (Model $record) => TreatmentSessionResource::getUrl('view', ['record' => $record]))
            ->headerActions([
                Action::make('create')
                    ->label('Nuova seduta')
                    ->url(fn () => TreatmentSessionResource::getUrl('create', ['patient' => $this->getOwnerRecord()->getKey()])),
            ])
            ->recordActions([
                Action::make('open')
                    ->label('Apri')
                    ->url(fn (Model $record) => TreatmentSessionResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
