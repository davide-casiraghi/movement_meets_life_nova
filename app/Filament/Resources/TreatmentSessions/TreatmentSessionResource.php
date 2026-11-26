<?php

namespace App\Filament\Resources\TreatmentSessions;

use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\TreatmentSessions\Pages\CreateTreatmentSession;
use App\Filament\Resources\TreatmentSessions\Pages\EditTreatmentSession;
use App\Filament\Resources\TreatmentSessions\Pages\ListTreatmentSessions;
use App\Filament\Resources\TreatmentSessions\Pages\ViewTreatmentSession;
use App\Models\Patient;
use App\Models\TreatmentSession;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentSessionResource extends Resource
{
    protected static ?string $model = TreatmentSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $slug = 'sedute';

    protected static ?string $modelLabel = 'seduta';

    protected static ?string $pluralModelLabel = 'sedute';

    protected static ?int $navigationSort = 10;

    /** Pain scale NRS 0-10 */
    private static function painOptions(): array
    {
        return collect(range(0, 10))->mapWithKeys(fn (int $n) => [(string) $n => (string) $n])->all();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Seduta')
                    ->columns(3)
                    ->schema([
                        Select::make('patient_id')
                            ->label('Paziente')
                            ->relationship('patient', 'last_name', fn (Builder $query) => $query->orderBy('last_name')->orderBy('first_name'))
                            ->getOptionLabelFromRecordUsing(fn (Patient $record) => $record->full_name)
                            ->searchable(['first_name', 'last_name'])
                            ->preload()
                            ->required()
                            ->default(fn () => request()->integer('patient') ?: null),
                        DateTimePicker::make('performed_at')->label('Data e ora')->seconds(false)->required()->default(now()),
                        TextInput::make('duration_minutes')->label('Durata (minuti)')->numeric()->minValue(1)->maxValue(600),
                        Select::make('pain_before')->label('Dolore prima (NRS 0-10)')->options(self::painOptions()),
                        Select::make('pain_after')->label('Dolore dopo (NRS 0-10)')->options(self::painOptions()),
                    ]),
                Section::make('Contenuto clinico')
                    ->description('Campi cifrati nel database.')
                    ->schema([
                        Textarea::make('assessment')->label('Valutazione')->rows(4),
                        Textarea::make('treatment')->label('Trattamento eseguito')->rows(4),
                        Textarea::make('home_exercises')->label('Esercizi a casa')->rows(3),
                        Textarea::make('notes')->label('Note')->rows(3),
                    ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Seduta')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('patient.full_name')
                            ->label('Paziente')
                            ->url(fn (TreatmentSession $record) => PatientResource::getUrl('view', ['record' => $record->patient_id])),
                        TextEntry::make('performed_at')->label('Data e ora')->dateTime('d/m/Y H:i'),
                        TextEntry::make('duration_minutes')->label('Durata')->suffix(' min')->placeholder('—'),
                        TextEntry::make('pain_before')->label('Dolore prima (NRS)')->placeholder('—'),
                        TextEntry::make('pain_after')->label('Dolore dopo (NRS)')->placeholder('—'),
                    ]),
                Section::make('Contenuto clinico')
                    ->schema([
                        TextEntry::make('assessment')->label('Valutazione')->placeholder('—'),
                        TextEntry::make('treatment')->label('Trattamento eseguito')->placeholder('—'),
                        TextEntry::make('home_exercises')->label('Esercizi a casa')->placeholder('—'),
                        TextEntry::make('notes')->label('Note')->placeholder('—'),
                    ]),
            ]);
    }

    /** Only the agenda data is listed; clinical content stays on the logged pages. */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('performed_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('patient.last_name')
                    ->label('Paziente')
                    ->formatStateUsing(fn (TreatmentSession $record) => $record->patient?->full_name)
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('duration_minutes')->label('Durata')->suffix(' min')->placeholder('—'),
            ])
            ->defaultSort('performed_at', 'desc')
            ->filters([
                SelectFilter::make('patient')
                    ->label('Paziente')
                    ->relationship('patient', 'last_name')
                    ->getOptionLabelFromRecordUsing(fn (Patient $record) => $record->full_name)
                    ->searchable()
                    ->preload(),
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

    public static function getRecordTitle(?Model $record): string
    {
        if (! $record) {
            return static::getModelLabel();
        }

        return 'Seduta del '.$record->performed_at?->format('d/m/Y').' – '.$record->patient?->full_name;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTreatmentSessions::route('/'),
            'create' => CreateTreatmentSession::route('/create'),
            'view' => ViewTreatmentSession::route('/{record}'),
            'edit' => EditTreatmentSession::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
