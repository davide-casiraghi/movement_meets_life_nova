<?php

namespace App\Filament\Resources\Patients;

use App\Filament\Resources\Patients\Pages\CreatePatient;
use App\Filament\Resources\Patients\Pages\EditPatient;
use App\Filament\Resources\Patients\Pages\ListPatients;
use App\Filament\Resources\Patients\Pages\ViewPatient;
use App\Filament\Resources\Patients\RelationManagers\TreatmentSessionsRelationManager;
use App\Models\Patient;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
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
        return $schema
            ->components([
                Section::make('Anagrafica')
                    ->columns(2)
                    ->schema([
                        TextInput::make('first_name')->label('Nome')->required()->maxLength(255),
                        TextInput::make('last_name')->label('Cognome')->required()->maxLength(255),
                        DatePicker::make('birth_date')->label('Data di nascita')->maxDate(now()),
                        TextInput::make('fiscal_code')->label('Codice fiscale')->maxLength(16)
                            ->dehydrateStateUsing(fn (?string $state) => $state ? strtoupper(trim($state)) : null),
                        TextInput::make('email')->label('Email')->email()->maxLength(255),
                        TextInput::make('phone')->label('Telefono')->tel()->maxLength(50),
                        TextInput::make('address')->label('Indirizzo')->maxLength(500)->columnSpanFull(),
                        TextInput::make('occupation')->label('Professione / attività')->maxLength(255),
                        DateTimePicker::make('privacy_notice_signed_at')
                            ->label('Informativa privacy firmata il')
                            ->seconds(false),
                    ]),
                Section::make('Dati clinici')
                    ->description('Campi cifrati nel database.')
                    ->schema([
                        Textarea::make('current_complaint')->label('Motivo della visita / anamnesi prossima')->rows(4),
                        Textarea::make('medical_history')->label('Anamnesi remota (patologie, interventi, traumi)')->rows(4),
                        Textarea::make('medications')->label('Farmaci')->rows(2),
                        Textarea::make('allergies')->label('Allergie')->rows(2),
                        Textarea::make('clinical_notes')->label('Note cliniche')->rows(4),
                    ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Anagrafica')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('first_name')->label('Nome'),
                        TextEntry::make('last_name')->label('Cognome'),
                        TextEntry::make('birth_date')->label('Data di nascita')->date('d/m/Y')->placeholder('—'),
                        TextEntry::make('fiscal_code')->label('Codice fiscale')->placeholder('—'),
                        TextEntry::make('email')->label('Email')->placeholder('—'),
                        TextEntry::make('phone')->label('Telefono')->placeholder('—'),
                        TextEntry::make('address')->label('Indirizzo')->placeholder('—'),
                        TextEntry::make('occupation')->label('Professione / attività')->placeholder('—'),
                        TextEntry::make('privacy_notice_signed_at')
                            ->label('Informativa privacy firmata il')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('Non ancora firmata'),
                    ]),
                Section::make('Dati clinici')
                    ->schema([
                        TextEntry::make('current_complaint')->label('Motivo della visita / anamnesi prossima')->placeholder('—'),
                        TextEntry::make('medical_history')->label('Anamnesi remota')->placeholder('—'),
                        TextEntry::make('medications')->label('Farmaci')->placeholder('—'),
                        TextEntry::make('allergies')->label('Allergie')->placeholder('—'),
                        TextEntry::make('clinical_notes')->label('Note cliniche')->placeholder('—'),
                    ]),
            ]);
    }

    /**
     * The table shows only personal data, never clinical data: clinical data
     * appears only on the view and edit pages, which write to the access log.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('last_name')->label('Cognome')->searchable()->sortable(),
                TextColumn::make('first_name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('birth_date')->label('Data di nascita')->date('d/m/Y')->sortable(),
                TextColumn::make('phone')->label('Telefono')->searchable(),
                TextColumn::make('treatment_sessions_count')->label('Sedute')->counts('treatmentSessions')->sortable(),
                TextColumn::make('privacy_notice_signed_at')
                    ->label('Informativa')
                    ->date('d/m/Y')
                    ->placeholder('Da firmare')
                    ->toggleable(),
            ])
            ->defaultSort('last_name')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
