<?php

namespace App\Filament\Resources\AccessLogs;

use App\Filament\Resources\AccessLogs\Pages\ListAccessLogs;
use App\Models\AccessLog;
use App\Models\Patient;
use App\Models\TreatmentSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

/**
 * Read-only view of the audit trail.
 */
class AccessLogResource extends Resource
{
    protected static ?string $model = AccessLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $slug = 'registro-accessi';

    protected static ?string $modelLabel = 'registro accessi';

    protected static ?string $pluralModelLabel = 'registro accessi';

    protected static ?string $navigationLabel = 'Registro accessi';

    protected static ?int $navigationSort = 11;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Quando')->dateTime('d/m/Y H:i:s')->sortable(),
                TextColumn::make('user.email')->label('Utente')->placeholder('—')->searchable(),
                TextColumn::make('event')
                    ->label('Evento')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => AccessLog::EVENT_LABELS[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'login_failed', 'force_deleted' => 'danger',
                        'deleted', 'updated' => 'warning',
                        'viewed' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('subject_type')
                    ->label('Dato')
                    ->formatStateUsing(fn (?string $state, AccessLog $record) => match ($state) {
                        (new Patient)->getMorphClass() => 'Paziente #'.$record->subject_id,
                        (new TreatmentSession)->getMorphClass() => 'Seduta #'.$record->subject_id,
                        default => $state,
                    })
                    ->placeholder('—'),
                TextColumn::make('properties')
                    ->label('Dettagli')
                    ->getStateUsing(function (AccessLog $record): ?string {
                        $properties = $record->properties ?? [];

                        return match (true) {
                            isset($properties['fields']) => 'Campi: '.implode(', ', $properties['fields']),
                            isset($properties['email']) => 'Email: '.$properties['email'],
                            default => null,
                        };
                    })
                    ->placeholder('—')
                    ->wrap(),
                TextColumn::make('ip_address')->label('IP')->toggleable(),
                TextColumn::make('user_agent')->label('Browser')->limit(40)->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('event')->label('Evento')->options(AccessLog::EVENT_LABELS),
                SelectFilter::make('user')->label('Utente')->relationship('user', 'email'),
                SelectFilter::make('subject_type')->label('Tipo di dato')->options([
                    (new Patient)->getMorphClass() => 'Paziente',
                    (new TreatmentSession)->getMorphClass() => 'Seduta',
                ]),
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('from')->label('Dal'),
                        DatePicker::make('until')->label('Al'),
                    ])
                    ->query(fn (Builder $query, array $data) => $query
                        ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '>=', $date))
                        ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '<=', $date))),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccessLogs::route('/'),
        ];
    }
}
