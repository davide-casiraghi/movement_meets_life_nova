<?php

namespace App\Filament\Resources\Services;

use App\Enums\VatCode;
use App\Filament\Support\FormHelpers;
use App\Filament\Resources\Services\Pages\ManageServices;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Tables\Filters\Indicator;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Listino prezzi: the services of the practice, with duration, VAT code and price.
 * Services are archived instead of deleted.
 */
class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $slug = 'listino-prezzi';

    protected static ?string $modelLabel = 'servizio';

    protected static ?string $pluralModelLabel = 'servizi';

    protected static ?string $navigationLabel = 'Listino prezzi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dati servizio')
                    ->columns(12)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->placeholder('Es. Prima visita fisioterapica')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        TextInput::make('code')
                            ->label(FormHelpers::optional('Codice'))
                            ->placeholder('Es. VISITA-60')
                            ->maxLength(50)
                            ->columnSpan(3),
                        Select::make('color')
                            ->label(FormHelpers::optional('Colore'))
                            ->options(FormHelpers::colorOptions())
                            ->allowHtml()
                            ->placeholder('Scegli')
                            ->native(false)
                            ->columnSpan(3),
                        Textarea::make('description')
                            ->label(FormHelpers::optional('Descrizione'))
                            ->placeholder('Aggiungi una nota interna o una breve descrizione')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                Section::make('Fiscalità e prezzo')
                    ->columns(3)
                    ->schema([
                        TextInput::make('duration_minutes')
                            ->label(FormHelpers::optional('Durata (in minuti)'))
                            ->placeholder('Es. 60')
                            ->integer()
                            ->minValue(1)
                            ->maxValue(600),
                        Select::make('vat_code')
                            ->label('Codice IVA')
                            ->options(VatCode::class)
                            ->searchable()
                            ->native(false)
                            ->required(),
                        TextInput::make('price')
                            ->label('Imponibile')
                            ->prefix('€')
                            ->placeholder('Es. 100,00')
                            ->inputMode('decimal')
                            ->required()
                            ->regex(FormHelpers::PRICE_REGEX)
                            ->validationMessages(['regex' => 'Inserisci un importo valido, es. 100,00'])
                            ->formatStateUsing(fn ($state) => FormHelpers::formatPrice($state))
                            ->dehydrateStateUsing(fn ($state) => FormHelpers::parsePrice($state)),
                    ]),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->weight('bold')
                    ->html()
                    ->formatStateUsing(fn (string $state, Service $record) => FormHelpers::colorDot($record->color).e($state))
                    ->description(fn (Service $record) => $record->code)
                    ->searchable(['name', 'code'])
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Durata')
                    ->suffix(' min')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Prezzo')
                    ->money('EUR', locale: 'it')
                    ->weight('bold')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->searchPlaceholder('Cerca per nome o codice')
            ->filters([
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'active' => 'Attivi',
                        'archived' => 'Archiviati',
                        'all' => 'Tutti',
                    ])
                    ->default('active')
                    ->selectablePlaceholder(false)
                    // "Attivi" is the normal view: show a badge only when something else is chosen.
                    ->indicateUsing(fn (array $data) => match ($data['value'] ?? 'active') {
                        'archived' => [Indicator::make('Stato: Archiviati')->removeField('value')],
                        'all' => [Indicator::make('Stato: Tutti')->removeField('value')],
                        default => [],
                    })
                    ->query(fn (Builder $query, array $data) => match ($data['value'] ?? 'active') {
                        'archived' => $query->archived(),
                        'all' => $query,
                        default => $query->active(),
                    }),
            ])
            ->filtersTriggerAction(fn (Action $action) => $action->button()->label('Filtri')->color('gray'))
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->label('Modifica')
                        ->modalHeading('Modifica servizio')
                        ->modalSubmitActionLabel('Salva'),
                    ReplicateAction::make()
                        ->label('Duplica')
                        ->icon(Heroicon::OutlinedDocumentDuplicate)
                        ->modalHeading('Duplica servizio')
                        ->modalSubmitActionLabel('Crea servizio')
                        ->schema(fn (Schema $schema) => static::form($schema))
                        ->excludeAttributes(['archived_at'])
                        ->mutateRecordDataUsing(function (array $data): array {
                            $data['name'] .= ' (copia)';

                            return $data;
                        })
                        ->successNotificationTitle('Servizio duplicato'),
                    Action::make('archive')
                        ->label('Archivia')
                        ->icon(Heroicon::OutlinedArchiveBoxArrowDown)
                        ->hidden(fn (Service $record) => $record->isArchived())
                        ->requiresConfirmation()
                        ->modalIcon(null)
                        ->modalHeading(fn (Service $record) => "Archiviare «{$record->name}»?")
                        ->modalDescription('Non si potrà più scegliere negli appuntamenti e nelle fatture. Quelli già fatti non cambiano. Si ripristina da «Filtri › Stato › Archiviati».')
                        ->modalSubmitActionLabel('Archivia')
                        ->color('primary')
                        ->action(fn (Service $record) => $record->archive())
                        ->successNotificationTitle('Servizio archiviato'),
                    Action::make('unarchive')
                        ->label('Ripristina')
                        ->icon(Heroicon::OutlinedArrowUturnLeft)
                        ->visible(fn (Service $record) => $record->isArchived())
                        ->action(fn (Service $record) => $record->unarchive())
                        ->successNotificationTitle('Servizio ripristinato'),
                ])->icon(Heroicon::EllipsisVertical),
            ])
            ->toolbarActions([
                BulkAction::make('archiveSelected')
                    ->label('Archivia selezionati')
                    ->icon(Heroicon::OutlinedArchiveBoxArrowDown)
                    ->hidden(fn (HasTable $livewire) => self::statusFilter($livewire) === 'archived')
                    ->requiresConfirmation()
                    ->modalHeading('Archiviare i servizi selezionati?')
                    ->modalDescription('Non si potranno più scegliere negli appuntamenti e nelle fatture. Quelli già fatti non cambiano. Si ripristinano da «Filtri › Stato › Archiviati».')
                    ->modalSubmitActionLabel('Archivia')
                    ->action(fn (Collection $records) => $records->reject->isArchived()->each->archive())
                    ->deselectRecordsAfterCompletion()
                    ->successNotificationTitle('Servizi archiviati'),
                // In the archive (and in "Tutti") the selected services can be brought back.
                BulkAction::make('unarchiveSelected')
                    ->label('Ripristina selezionati')
                    ->icon(Heroicon::OutlinedArrowUturnLeft)
                    ->visible(fn (HasTable $livewire) => in_array(self::statusFilter($livewire), ['archived', 'all'], true))
                    ->action(fn (Collection $records) => $records->filter->isArchived()->each->unarchive())
                    ->deselectRecordsAfterCompletion()
                    ->successNotificationTitle('Servizi ripristinati'),
            ]);
    }

    /** Current value of the "Stato" filter: active, archived or all. */
    private static function statusFilter(HasTable $livewire): string
    {
        return $livewire->getTableFilterState('status')['value'] ?? 'active';
    }




    public static function getPages(): array
    {
        return [
            'index' => ManageServices::route('/'),
        ];
    }
}
