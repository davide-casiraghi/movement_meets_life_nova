<?php

namespace App\Filament\Resources\Patients;

use App\Filament\Resources\Patients\Pages\CreatePatient;
use App\Filament\Resources\Patients\Pages\EditPatient;
use App\Filament\Resources\Patients\Pages\ListPatients;
use App\Filament\Resources\Patients\Pages\ViewPatient;
use App\Filament\Resources\Patients\RelationManagers\TreatmentSessionsRelationManager;
use App\Models\Patient;
use BackedEnum;
use App\Filament\Resources\Patients\Schemas\PatientForm;
use App\Filament\Resources\Patients\Schemas\PatientInfolist;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $slug = 'pazienti';

    protected static ?string $modelLabel = 'paziente';

    protected static ?string $pluralModelLabel = 'pazienti';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PatientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PatientInfolist::configure($schema);
    }

    /**
     * The table shows only personal data, never clinical data: clinical data
     * appears only on the view and edit pages, which write to the access log.
     * "Tutti / Attivi / Archiviati" is the select next to the search field
     * (ListPatients::$status); archived patients are the soft-deleted ones.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query, HasTable $livewire) => match ($livewire->status ?? 'all') {
                'active' => $query,
                'archived' => $query->onlyTrashed(),
                default => $query->withTrashed(),
            })
            ->columns([
                TextColumn::make('last_name')
                    ->label('Nome paziente')
                    ->html()
                    ->formatStateUsing(fn (Patient $record) => sprintf(
                        '<div class="gest-patient-cell"><span class="gest-status-dot %s" title="%s"></span><div><div class="gest-patient-name">%s</div><div class="gest-patient-email">%s</div></div></div>',
                        $record->trashed() ? 'gest-status-dot-off' : 'gest-status-dot-on',
                        $record->trashed() ? 'Archiviato' : 'Attivo',
                        e($record->full_name),
                        e($record->email ?? ''),
                    ))
                    ->searchable(['first_name', 'last_name', 'email'])
                    ->sortable(['last_name', 'first_name']),
                TextColumn::make('fiscal_code')
                    ->label('Cod. fiscale')
                    ->placeholder('—'),
                TextColumn::make('ts_transmission')
                    ->label('TS')
                    ->badge()
                    ->formatStateUsing(fn (bool $state) => $state ? 'Sì' : 'No')
                    ->color(fn (bool $state) => $state ? 'success' : 'danger'),
                TextColumn::make('contacts')
                    ->label('Telefono')
                    ->html()
                    ->state(fn (Patient $record) => '<div class="gest-patient-phones"><div><strong>Cell:</strong> '.e($record->mobile ?? '').'</div><div class="gest-patient-email">Tel: '.e($record->phone ?? '').'</div></div>')
                    ->searchable(query: fn (Builder $query, string $search) => $query->where(
                        fn (Builder $query) => $query->where('mobile', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%")
                    )),
            ])
            ->defaultSort('last_name')
            ->searchPlaceholder('Cerca paziente...')
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(50)
            ->filters([
                TernaryFilter::make('ts_transmission')
                    ->label('Trasmissione Sistema TS')
                    ->trueLabel('Sì')
                    ->falseLabel('No'),
                TernaryFilter::make('representatives')
                    ->label('Rappresentante legale')
                    ->trueLabel('Con rappresentante')
                    ->falseLabel('Senza rappresentante')
                    ->queries(
                        true: fn (Builder $query) => $query->has('representatives'),
                        false: fn (Builder $query) => $query->doesntHave('representatives'),
                    ),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Apri')
                    ->icon(Heroicon::ChevronRight)
                    ->iconButton()
                    ->color('gray'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Archivia selezionati')
                        ->icon(Heroicon::OutlinedArchiveBox)
                        ->modalHeading('Archiviare i pazienti selezionati?')
                        ->modalDescription('Non compariranno più tra i pazienti attivi. Le loro schede e le sedute restano conservate e puoi ripristinarli quando vuoi.')
                        ->modalSubmitActionLabel('Archivia'),
                    RestoreBulkAction::make()->label('Ripristina selezionati'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TreatmentSessionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'view' => ViewPatient::route('/{record}'),
            'edit' => EditPatient::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->full_name;
    }

    public static function getRecordTitle(?Model $record): string
    {
        return $record?->full_name ?? static::getModelLabel();
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
