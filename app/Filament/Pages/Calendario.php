<?php

namespace App\Filament\Pages;

use App\Enums\AppointmentStatus;
use App\Enums\AppointmentType;
use App\Filament\Forms\Components\ServiceTitleInput;
use App\Filament\Support\FormHelpers;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use App\Services\Gestionale\AvailabilityFinder;
use BackedEnum;
use Carbon\CarbonImmutable;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\View;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Calendar of the practice: day / week / month / agenda views (FullCalendar),
 * "Nuovo evento" modal with the price list services and "Trova disponibilità".
 */
class Calendario extends Page
{
    protected static ?string $slug = 'calendario';

    protected static ?string $navigationLabel = 'Calendario';

    protected static ?string $title = 'Calendario';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.calendario';

    /** Durations offered by "Trova disponibilità" (minutes). */
    public const DURATIONS = [15, 30, 45, 60, 90];

    /** Max occurrences created for a recurring event. */
    public const MAX_OCCURRENCES = 104;

    public static function canAccess(): bool
    {
        return (bool) auth()->user()?->can('viewAny', Appointment::class);
    }

    public function getHeading(): string
    {
        return '';
    }

    // ------------------------------------------------------------------
    // Data for the calendar (called from resources/js/gestionale-calendar.js)
    // ------------------------------------------------------------------

    /**
     * Events between two ISO dates, as FullCalendar event objects.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getEvents(string $start, string $end, ?int $professionalId = null, bool $showCancelled = false): array
    {
        $tz = config('gestionale.timezone');

        return Appointment::query()
            ->with('patient:id,first_name,last_name')
            ->overlapping(CarbonImmutable::parse($start)->utc(), CarbonImmutable::parse($end)->utc())
            ->when($professionalId, fn ($q) => $q->where(fn ($q) => $q->where('user_id', $professionalId)->orWhereNull('user_id')))
            ->when(! $showCancelled, fn ($q) => $q->where('status', '!=', AppointmentStatus::Cancelled->value))
            ->orderBy('starts_at')
            ->get()
            ->map(fn (Appointment $a) => [
                'id' => (string) $a->id,
                'title' => $a->patient ? "{$a->patient->full_name} · {$a->title}" : $a->title,
                'start' => $a->starts_at->copy()->setTimezone($tz)->toIso8601String(),
                'end' => $a->ends_at->copy()->setTimezone($tz)->toIso8601String(),
                'backgroundColor' => $a->color ?? ($a->type === AppointmentType::Holiday ? '#E0E0E0' : '#A8B8F8'),
                'borderColor' => $a->color ?? ($a->type === AppointmentType::Holiday ? '#E0E0E0' : '#A8B8F8'),
                'textColor' => '#111827',
                'classNames' => ['gest-event-'.$a->status->value],
            ])
            ->all();
    }

    /**
     * Click on a free slot of "Trova disponibilità": writes start, end and professional
     * straight into the open event form (times in the practice time zone).
     * Done here rather than with three $wire.$set() calls, which would fire the
     * "keep the same duration" hook of the start field with the new end already set.
     */
    public function pickAvailabilitySlot(string $start, string $end, ?int $professionalId = null): void
    {
        $key = array_key_last($this->mountedActions ?? []);

        if ($key === null || ! in_array($this->mountedActions[$key]['name'] ?? null, ['createEvent', 'editEvent'], true)) {
            return;
        }

        $this->mountedActions[$key]['data']['starts_at'] = CarbonImmutable::parse($start)->format('Y-m-d H:i:s');
        $this->mountedActions[$key]['data']['ends_at'] = CarbonImmutable::parse($end)->format('Y-m-d H:i:s');

        if ($professionalId) {
            $this->mountedActions[$key]['data']['user_id'] = $professionalId;
        }
    }

    /** Drag & drop / resize in the calendar. */
    public function moveEvent(int $id, string $start, string $end): bool
    {
        $appointment = Appointment::findOrFail($id);
        $this->authorize('update', $appointment);

        $appointment->update([
            'starts_at' => CarbonImmutable::parse($start)->utc(),
            'ends_at' => CarbonImmutable::parse($end)->utc(),
        ]);

        return true;
    }

    // ------------------------------------------------------------------
    // Actions
    // ------------------------------------------------------------------

    public function createEventAction(): Action
    {
        return $this->configureEventModal(Action::make('createEvent'))
            ->label('Nuovo evento')
            ->modalHeading('Nuovo evento')
            ->authorize(fn () => auth()->user()->can('create', Appointment::class))
            ->fillForm(function (array $arguments): array {
                $tz = config('gestionale.timezone');
                $start = isset($arguments['start'])
                    ? CarbonImmutable::parse($arguments['start'])->setTimezone($tz)
                    : CarbonImmutable::now($tz)->addMinutes(15 - CarbonImmutable::now($tz)->minute % 15)->second(0);
                $end = isset($arguments['end']) ? CarbonImmutable::parse($arguments['end'])->setTimezone($tz) : $start->addHour();

                // A click on a single 15-minute cell proposes one hour.
                if ($end->diffInMinutes($start, true) <= 15) {
                    $end = $start->addHour();
                }

                return [
                    'type' => AppointmentType::Work->value,
                    'status' => AppointmentStatus::Scheduled->value,
                    'user_id' => auth()->id(),
                    'starts_at' => $start->utc()->format('Y-m-d H:i:s'),
                    'ends_at' => $end->utc()->format('Y-m-d H:i:s'),
                    'show_availability' => false,
                ];
            })
            ->action(function (array $data): void {
                $occurrences = $this->createAppointments($data);

                Notification::make()
                    ->success()
                    ->title($occurrences > 1 ? "Creati {$occurrences} eventi" : 'Evento creato')
                    ->send();

                $this->dispatch('gestionale-calendar-refresh');
            });
    }

    public function editEventAction(): Action
    {
        return $this->configureEventModal(Action::make('editEvent'))
            ->modalHeading('Modifica evento')
            ->record(fn (array $arguments) => Appointment::find($arguments['id'] ?? null))
            ->authorize(fn (?Appointment $record) => $record && auth()->user()->can('update', $record))
            ->fillForm(function (Appointment $record): array {
                // Opening the event shows its notes: write it to the access log.
                $record->logView();

                return [
                    ...Arr::only($record->attributesToArray(), [
                        'type', 'status', 'patient_id', 'service_id', 'user_id', 'title', 'color', 'address',
                    ]),
                    'type' => $record->type->value,
                    'status' => $record->status->value,
                    'notes' => $record->notes,
                    'price' => FormHelpers::formatPrice($record->price),
                    'starts_at' => $record->starts_at->format('Y-m-d H:i:s'),
                    'ends_at' => $record->ends_at->format('Y-m-d H:i:s'),
                    'show_availability' => false,
                ];
            })
            ->action(function (array $data, Appointment $record): void {
                $record->update($this->appointmentAttributes($data));

                Notification::make()->success()->title('Evento aggiornato')->send();
                $this->dispatch('gestionale-calendar-refresh');
            })
            ->extraModalFooterActions(fn (Action $action) => [
                Action::make('deleteEvent')
                    ->label('Elimina')
                    ->color('danger')
                    ->link()
                    ->requiresConfirmation()
                    ->modalHeading('Eliminare questo evento?')
                    ->modalDescription('L\'evento viene tolto dal calendario.')
                    ->modalSubmitActionLabel('Elimina')
                    ->action(function () use ($action): void {
                        $record = $action->getRecord();
                        $this->authorize('delete', $record);
                        $record->delete();

                        Notification::make()->success()->title('Evento eliminato')->send();
                        $this->dispatch('gestionale-calendar-refresh');
                    })
                    ->cancelParentActions(),
            ]);
    }

    private function configureEventModal(Action $action): Action
    {
        return $action
            ->schema(fn (Action $action) => $this->eventFormSchema($action->getRecord()))
            ->modalWidth(Width::SixExtraLarge)
            ->modalSubmitActionLabel('Salva evento')
            ->modalCancelActionLabel('Annulla')
            ->modalFooterActionsAlignment(Alignment::Between)
            ->extraModalWindowAttributes(['class' => 'gest-event-modal']);
    }

    // ------------------------------------------------------------------
    // Form
    // ------------------------------------------------------------------

    private function eventFormSchema(?Appointment $record): array
    {
        return [
            Hidden::make('service_id'),
            Hidden::make('show_availability')->default(false)->dehydrated(false),

            Grid::make(3)
                ->extraAttributes(['class' => 'gest-event-layout'])
                ->schema([
                    Tabs::make()
                        ->columnSpan(fn (Get $get) => $get('show_availability') ? 2 : 3)
                        ->tabs([
                            Tab::make('Generale')->schema($this->generalTab()),
                            Tab::make('Note')->schema([
                                Textarea::make('notes')
                                    ->hiddenLabel()
                                    ->placeholder('Note interne sull\'evento (cifrate nel database)')
                                    ->rows(12),
                            ]),
                        ]),

                    Group::make($this->availabilityPanel($record))
                        ->visible(fn (Get $get) => (bool) $get('show_availability'))
                        ->extraAttributes(['class' => 'gest-availability-panel']),
                ]),
        ];
    }

    private function generalTab(): array
    {
        return [
            Grid::make(12)->schema([
                Select::make('type')
                    ->label('Tipo')
                    ->options(AppointmentType::class)
                    ->required()
                    ->native(false)
                    ->selectablePlaceholder(false)
                    ->columnSpan(3),
                Select::make('status')
                    ->label('Stato')
                    ->options(AppointmentStatus::class)
                    ->required()
                    ->native(false)
                    ->selectablePlaceholder(false)
                    ->columnSpan(3),
                TextEntry::make('calendar_name')
                    ->label('Calendario')
                    ->state(fn () => new HtmlString('<span class="gest-calendar-chip"><span class="gest-color-dot" style="background:#5B82E6"></span>'.e(config('gestionale.calendar_name')).'</span>'))
                    ->columnSpan(6),

                Select::make('patient_id')
                    ->label(FormHelpers::optional('Paziente'))
                    ->placeholder('Cerca paziente...')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search) => Patient::query()
                        ->where(fn ($q) => $q->where('last_name', 'like', "%{$search}%")->orWhere('first_name', 'like', "%{$search}%"))
                        ->orderBy('last_name')->limit(50)->get()
                        ->mapWithKeys(fn (Patient $p) => [$p->id => $p->full_name]))
                    ->getOptionLabelUsing(fn ($value) => Patient::withTrashed()->find($value)?->full_name)
                    ->createOptionForm([
                        Grid::make(2)->schema([
                            TextInput::make('first_name')->label('Nome')->required()->maxLength(255),
                            TextInput::make('last_name')->label('Cognome')->required()->maxLength(255),
                            TextInput::make('mobile')->label(FormHelpers::optional('Cellulare'))->tel()->maxLength(50),
                            TextInput::make('email')->label(FormHelpers::optional('Email'))->email()->maxLength(255),
                        ]),
                    ])
                    // Quick entry: the full registry (fiscal code, address, ...) is completed later from Pazienti.
                    ->createOptionModalHeading('Nuovo paziente')
                    ->createOptionUsing(fn (array $data) => Patient::create($data)->getKey())
                    ->createOptionAction(fn (Action $action) => $action->icon(Heroicon::UserPlus)->color('gray')->tooltip('Nuovo paziente'))
                    ->columnSpan(12),

                ServiceTitleInput::make('title')
                    ->label('Titolo')
                    ->placeholder('Inserisci descrizione servizio')
                    ->required()
                    ->maxLength(255)
                    ->afterStateUpdated(fn (?string $state, Get $get, Set $set) => $this->applyService($state, $get, $set))
                    ->columnSpan(7),
                TextInput::make('price')
                    ->label(FormHelpers::optional('Prezzo'))
                    ->placeholder('0,00')
                    ->suffix('€')
                    ->inputMode('decimal')
                    ->regex(FormHelpers::PRICE_REGEX)
                    ->validationMessages(['regex' => 'Inserisci un importo valido, es. 50,00'])
                    ->columnSpan(3),
                Select::make('color')
                    ->label(new HtmlString('&nbsp;'))
                    ->options(FormHelpers::colorOptions())
                    ->allowHtml()
                    ->native(false)
                    ->placeholder('Colore')
                    ->columnSpan(2),
            ]),

            Section::make('Quando')
                ->key('when')
                ->compact()
                ->afterHeader([
                    Action::make('findAvailability')
                        ->label('Trova disponibilità')
                        ->icon(Heroicon::OutlinedCalendarDays)
                        ->color('primary')
                        ->outlined(fn (Get $get) => (bool) $get('show_availability'))
                        ->size('sm')
                        ->action(fn (Get $get, Set $set) => $this->toggleAvailability($get, $set)),
                ])
                ->schema([
                    Grid::make(12)->schema([
                        DateTimePicker::make('starts_at')
                            ->label('Data inizio')
                            ->native(false)
                            ->displayFormat('d-m-Y H:i')
                            ->seconds(false)
                            ->minutesStep(5)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($old, $state, Get $get, Set $set) => $this->keepDuration($old, $state, $get, $set))
                            ->columnSpan(4),
                        DateTimePicker::make('ends_at')
                            ->label('Data fine')
                            ->native(false)
                            ->displayFormat('d-m-Y H:i')
                            ->seconds(false)
                            ->minutesStep(5)
                            ->required()
                            ->after('starts_at')
                            ->validationMessages(['after' => 'La fine deve essere dopo l\'inizio.'])
                            ->columnSpan(4),
                        Checkbox::make('recurring')
                            ->label('Evento ricorrente')
                            ->live()
                            ->dehydrated()
                            ->visible(fn (?Appointment $record) => $record === null)
                            ->extraFieldWrapperAttributes(['class' => 'gest-recurring-box'])
                            ->columnSpan(4),
                        Select::make('recurrence_frequency')
                            ->label('Si ripete')
                            ->options([
                                'daily' => 'Ogni giorno',
                                'weekly' => 'Ogni settimana',
                                'biweekly' => 'Ogni 2 settimane',
                                'monthly' => 'Ogni mese',
                            ])
                            ->default('weekly')
                            ->native(false)
                            ->required(fn (Get $get) => (bool) $get('recurring'))
                            ->visible(fn (Get $get, ?Appointment $record) => $record === null && $get('recurring'))
                            ->columnSpan(5),
                        DatePicker::make('recurrence_until')
                            ->label('Fino al')
                            ->native(false)
                            ->displayFormat('d-m-Y')
                            ->required(fn (Get $get) => (bool) $get('recurring'))
                            ->visible(fn (Get $get, ?Appointment $record) => $record === null && $get('recurring'))
                            ->columnSpan(4),
                        TextInput::make('address')
                            ->label(FormHelpers::optional('Indirizzo'))
                            ->placeholder('Via Giuseppe Verdi 45, Milano')
                            ->suffixIcon(Heroicon::OutlinedMapPin)
                            ->maxLength(255)
                            ->columnSpan(12),
                    ]),
                ]),

            Section::make('Risorse')
                ->compact()
                ->schema([
                    Select::make('user_id')
                        ->label(FormHelpers::optional('Professionista'))
                        ->options(fn () => $this->professionalOptions())
                        ->native(false),
                ]),
        ];
    }

    private function availabilityPanel(?Appointment $record): array
    {
        return [
            Section::make('Trova disponibilità')
                ->icon(Heroicon::OutlinedMagnifyingGlass)
                ->compact()
                ->afterHeader([
                    Action::make('closeAvailability')
                        ->iconButton()
                        ->icon(Heroicon::OutlinedChevronDoubleRight)
                        ->color('gray')
                        ->tooltip('Chiudi')
                        ->action(fn (Set $set) => $set('show_availability', false)),
                ])
                ->schema([
                    Select::make('av_service')
                        ->label('Prestazione')
                        ->placeholder('Prestazione o titolo')
                        ->options(fn () => Service::active()->orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->live()
                        ->dehydrated(false)
                        ->afterStateUpdated(function ($state, Set $set) {
                            $minutes = Service::find($state)?->duration_minutes;
                            if ($minutes) {
                                $set('av_duration', in_array($minutes, self::DURATIONS, true) ? (string) $minutes : 'other');
                                $set('av_duration_custom', $minutes);
                            }
                        }),
                    ToggleButtons::make('av_duration')
                        ->label('Durata (in minuti)')
                        // Built with "+" on purpose: spreading would renumber the integer keys (15 => 0, 30 => 1, ...).
                        ->options(collect(self::DURATIONS)->mapWithKeys(fn (int $m) => [$m => (string) $m])->all() + ['other' => 'Altro'])
                        ->inline()
                        ->live()
                        ->dehydrated(false),
                    TextInput::make('av_duration_custom')
                        ->label('Minuti')
                        ->integer()
                        ->minValue(5)
                        ->maxValue(600)
                        ->live(debounce: 500)
                        ->dehydrated(false)
                        ->visible(fn (Get $get) => $get('av_duration') === 'other'),
                    Grid::make(2)->schema([
                        Select::make('av_professional')
                            ->label('Professionista')
                            ->options(fn () => $this->professionalOptions())
                            ->placeholder('Tutti')
                            ->native(false)
                            ->live()
                            ->dehydrated(false),
                        Select::make('av_days')
                            ->label('Quando')
                            ->options([7 => 'Prossimi 7 giorni', 14 => 'Prossimi 14 giorni', 30 => 'Prossimi 30 giorni'])
                            ->default(14)
                            ->selectablePlaceholder(false)
                            ->native(false)
                            ->live()
                            ->dehydrated(false),
                    ]),
                    ToggleButtons::make('av_weekdays')
                        ->hiddenLabel()
                        ->options(['all' => 'Tutti i giorni', 'weekdays' => 'Lun - Ven', 'weekend' => 'Sab - Dom'])
                        ->default('all')
                        ->inline()
                        ->grouped()
                        ->live()
                        ->dehydrated(false),
                    ToggleButtons::make('av_group')
                        ->label('Raggruppa per')
                        ->options(['day' => 'Giorno', 'professional' => 'Professionista'])
                        ->default('day')
                        ->inline()
                        ->grouped()
                        ->live()
                        ->dehydrated(false),
                    View::make('filament.gestionale.availability-slots')
                        ->viewData(fn (Get $get) => $this->availabilityData($get, $record)),
                ]),
        ];
    }

    // ------------------------------------------------------------------
    // Form behaviour
    // ------------------------------------------------------------------

    /** When the title is a service of the price list, copy its price, colour and duration. */
    private function applyService(?string $title, Get $get, Set $set): void
    {
        $service = filled($title) ? Service::active()->where('name', trim($title))->first() : null;

        $set('service_id', $service?->id);

        if (! $service) {
            return;
        }

        $set('price', FormHelpers::formatPrice($service->price));

        if ($service->color) {
            $set('color', $service->color);
        }

        if ($service->duration_minutes && filled($get('starts_at'))) {
            $set('ends_at', CarbonImmutable::parse($get('starts_at'))->addMinutes($service->duration_minutes)->format('Y-m-d H:i:s'));
        }

        $set('av_service', $service->id);
        $set('av_duration', in_array($service->duration_minutes, self::DURATIONS, true) ? (string) $service->duration_minutes : 'other');
        $set('av_duration_custom', $service->duration_minutes);
    }

    /** Moving the start keeps the same duration. */
    private function keepDuration(?string $old, ?string $new, Get $get, Set $set): void
    {
        if (blank($old) || blank($new) || blank($get('ends_at'))) {
            return;
        }

        $minutes = CarbonImmutable::parse($old)->diffInMinutes(CarbonImmutable::parse($get('ends_at')), false);

        if ($minutes > 0) {
            $set('ends_at', CarbonImmutable::parse($new)->addMinutes((int) $minutes)->format('Y-m-d H:i:s'));
        }
    }

    private function toggleAvailability(Get $get, Set $set): void
    {
        $open = ! $get('show_availability');
        $set('show_availability', $open);

        if (! $open) {
            return;
        }

        // The panel was hidden while the form was filled, so its defaults were not applied.
        if (blank($get('av_duration'))) {
            // Start from the length of the event being edited.
            $minutes = (filled($get('starts_at')) && filled($get('ends_at')))
                ? (int) CarbonImmutable::parse($get('starts_at'))->diffInMinutes(CarbonImmutable::parse($get('ends_at')), true)
                : 60;
            $minutes = $minutes > 0 ? $minutes : 60;

            $set('av_duration', in_array($minutes, self::DURATIONS, true) ? (string) $minutes : 'other');
            $set('av_duration_custom', $minutes);
        }

        if (blank($get('av_service'))) {
            $set('av_service', $get('service_id'));
        }

        if (blank($get('av_professional'))) {
            $set('av_professional', $get('user_id'));
        }

        foreach (['av_days' => 14, 'av_weekdays' => 'all', 'av_group' => 'day'] as $field => $default) {
            if (blank($get($field))) {
                $set($field, $default);
            }
        }
    }

    /**
     * Free slots for the availability panel, already grouped for the view.
     */
    private function availabilityData(Get $get, ?Appointment $record): array
    {
        $duration = $get('av_duration') === 'other' ? (int) $get('av_duration_custom') : (int) $get('av_duration');
        $professionals = $this->professionalOptions();
        $ids = filled($get('av_professional')) ? [(int) $get('av_professional')] : array_keys($professionals);
        $weekdays = match ($get('av_weekdays')) {
            'weekdays' => [1, 2, 3, 4, 5],
            'weekend' => [6, 7],
            default => [1, 2, 3, 4, 5, 6, 7],
        };
        $tz = config('gestionale.timezone');

        $slots = app(AvailabilityFinder::class)->find(
            durationMinutes: $duration,
            professionalIds: $ids,
            fromDay: CarbonImmutable::now($tz),
            days: (int) ($get('av_days') ?: 14),
            weekdays: $weekdays,
            ignoreAppointmentId: $record?->id,
        );

        $currentUser = (int) $get('user_id');
        // $get() returns dates already cast back to UTC.
        $selectedStart = filled($get('starts_at'))
            ? CarbonImmutable::parse($get('starts_at'), 'UTC')->setTimezone($tz)->format('Y-m-d H:i')
            : null;

        $toButton = fn (array $slot, ?int $professionalId = null) => [
            'label' => $slot['start']->format('H:i'),
            'start' => $slot['start']->format('Y-m-d H:i:s'),
            'end' => $slot['end']->format('Y-m-d H:i:s'),
            'professional' => $professionalId
                ?? (in_array($currentUser, $slot['professional_ids'], true) ? $currentUser : $slot['professional_ids'][0]),
            'selected' => $selectedStart === $slot['start']->format('Y-m-d H:i'),
        ];

        $byDay = fn (Collection $daySlots, ?int $professionalId = null) => $daySlots
            ->groupBy(fn ($slot) => $slot['start']->toDateString())
            ->map(fn (Collection $items) => [
                'label' => $this->dayLabel($items->first()['start']),
                'slots' => $items->map(fn ($slot) => $toButton($slot, $professionalId))->values()->all(),
            ])
            ->values()
            ->all();

        $groups = $get('av_group') === 'professional'
            ? collect($ids)->map(fn (int $id) => [
                'label' => $professionals[$id] ?? 'Professionista',
                'days' => $byDay($slots->filter(fn ($slot) => in_array($id, $slot['professional_ids'], true)), $id),
            ])->all()
            : [['label' => null, 'days' => $byDay($slots)]];

        return [
            'ready' => $duration >= 5,
            'total' => $slots->count(),
            'groups' => $groups,
        ];
    }

    private function dayLabel(CarbonImmutable $day): string
    {
        $today = CarbonImmutable::now($day->timezone)->startOfDay();
        $date = $day->locale('it')->translatedFormat('j M');

        return match (true) {
            $day->isSameDay($today) => "Oggi {$date}",
            $day->isSameDay($today->addDay()) => "Domani {$date}",
            default => Str::ucfirst($day->locale('it')->translatedFormat('D')).' '.$date,
        };
    }

    /** @return array<int, string> */
    private function professionalOptions(): array
    {
        return User::role(User::PHYSIOTHERAPIST_ROLE)
            ->orderBy('email')
            ->pluck('email', 'id')
            ->all();
    }

    // ------------------------------------------------------------------
    // Saving
    // ------------------------------------------------------------------

    private function appointmentAttributes(array $data): array
    {
        return [
            'type' => $data['type'],
            'status' => $data['status'],
            'patient_id' => $data['patient_id'] ?? null,
            'service_id' => $data['service_id'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'title' => trim($data['title']),
            'price' => FormHelpers::parsePrice($data['price'] ?? null),
            'color' => $data['color'] ?? null,
            'starts_at' => CarbonImmutable::parse($data['starts_at']),
            'ends_at' => CarbonImmutable::parse($data['ends_at']),
            'address' => $data['address'] ?? null,
            'notes' => $data['notes'] ?? null,
        ];
    }

    /** Creates the event, and its repetitions when it is recurring. Returns how many were created. */
    private function createAppointments(array $data): int
    {
        $attributes = $this->appointmentAttributes($data);

        if (empty($data['recurring']) || blank($data['recurrence_until'] ?? null)) {
            Appointment::create($attributes);

            return 1;
        }

        $tz = config('gestionale.timezone');
        $group = (string) Str::uuid();
        $start = $attributes['starts_at']->setTimezone($tz);
        $length = $attributes['starts_at']->diffInMinutes($attributes['ends_at'], true);
        $until = CarbonImmutable::parse($data['recurrence_until'], $tz)->endOfDay();
        $count = 0;

        for ($i = 0; $count < self::MAX_OCCURRENCES; $i++) {
            $occurrence = match ($data['recurrence_frequency']) {
                'daily' => $start->addDays($i),
                'biweekly' => $start->addWeeks(2 * $i),
                'monthly' => $start->addMonthsNoOverflow($i),
                default => $start->addWeeks($i),
            };

            if ($occurrence->gt($until)) {
                break;
            }

            Appointment::create([
                ...$attributes,
                'starts_at' => $occurrence->utc(),
                'ends_at' => $occurrence->addMinutes($length)->utc(),
                'recurrence_group' => $group,
            ]);
            $count++;
        }

        return $count;
    }
}
