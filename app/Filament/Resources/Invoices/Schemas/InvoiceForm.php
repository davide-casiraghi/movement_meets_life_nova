<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Enums\AppointmentStatus;
use App\Enums\InvoiceType;
use App\Enums\PaymentMethod;
use App\Enums\PensionFund;
use App\Enums\TaxRegime;
use App\Enums\VatCode;
use App\Enums\WithholdingReason;
use App\Enums\WithholdingType;
use App\Filament\Forms\Components\ServiceTitleInput;
use App\Filament\Resources\Patients\Schemas\PatientForm;
use App\Filament\Support\FormHelpers;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Service;
use App\Services\Gestionale\InvoiceCalculator;
use Carbon\CarbonImmutable;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

/**
 * "Nuovo documento contabile": Generali, Prestazione (the lines), Tassazione,
 * Coordinate bancarie, Altro, and the sticky bar with the totals at the bottom.
 * Defaults come from config('gestionale.invoice').
 */
class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                self::general(),
                self::lines(),
                self::taxation(),
                self::bank(),
                self::other(),
                View::make('filament.gestionale.invoice-summary')
                    ->viewData(fn (Get $get) => self::summary($get)),
            ]);
    }

    private static function general()
    {
        return PatientForm::darkSection('Generali', 'Informazioni relative alla fatturazione', Heroicon::UserCircle)
            ->columns(3)
            ->schema([
                Select::make('patient_id')
                    ->label('Paziente')
                    ->placeholder('Cerca paziente...')
                    ->options(fn () => Patient::query()
                        ->orderBy('last_name')->orderBy('first_name')
                        ->get()
                        ->mapWithKeys(fn (Patient $p) => [$p->id => $p->full_name.($p->birth_date ? ' - '.$p->birth_date->format('d/m/Y') : '')]))
                    ->searchable()
                    ->required(),
                Select::make('type')
                    ->label('Tipo documento')
                    ->options(InvoiceType::class)
                    ->default(config('gestionale.invoice.type'))
                    ->selectablePlaceholder(false)
                    ->required(),
                TextInput::make('number')
                    ->label('Numero')
                    ->integer()
                    ->minValue(1)
                    ->default(fn () => Invoice::nextNumber((int) now()->year))
                    ->required()
                    ->rule(fn (Get $get): Closure => function (string $attribute, mixed $value, Closure $fail) use ($get): void {
                        $year = self::year($get('issued_on'));

                        if ($year && Invoice::query()->where('year', $year)->where('number', (int) $value)->exists()) {
                            $fail("Il numero {$value} è già stato usato nel {$year}: il primo libero è ".Invoice::nextNumber($year).'.');
                        }
                    }),

                self::date('issued_on', 'Data documento')
                    ->default(today())
                    ->required()
                    ->live()
                    // A new year starts a new sequence.
                    ->afterStateUpdated(function (?string $old, ?string $state, Set $set) {
                        if (self::year($old) !== self::year($state) && self::year($state)) {
                            $set('number', Invoice::nextNumber(self::year($state)));
                        }
                    }),
                Select::make('payment_method')
                    ->label('Metodo pagamento')
                    ->options(PaymentMethod::class)
                    ->default(config('gestionale.invoice.payment_method'))
                    ->placeholder('Seleziona metodo pagamento')
                    ->required(),
                Group::make([
                    Text::make(new HtmlString('<span class="gest-field-label">Stato documento<sup class="gest-required">*</sup></span>')),
                    Checkbox::make('paid')
                        ->label('Pagato')
                        ->live()
                        ->afterStateUpdated(fn (bool $state, Get $get, Set $set) => $state && blank($get('paid_on')) ? $set('paid_on', today()->format('Y-m-d')) : null)
                        ->extraFieldWrapperAttributes(fn (Get $get) => ['class' => 'gest-paid-box '.($get('paid') ? 'gest-paid-box-on' : 'gest-paid-box-off')]),
                ])->extraAttributes(['class' => 'gest-paid-group']),

                self::date('paid_on', 'Data incasso')
                    ->hintIcon(Heroicon::QuestionMarkCircle, tooltip: "Il giorno in cui hai ricevuto il pagamento. Conta per l'incassato e per il Sistema TS.")
                    ->required(fn (Get $get) => (bool) $get('paid'))
                    ->visible(fn (Get $get) => (bool) $get('paid')),
                self::date('due_on', 'Termine ultimo pagamento')
                    ->label(FormHelpers::optional('Termine ultimo pagamento'))
                    ->afterOrEqual('issued_on'),
            ]);
    }

    private static function lines()
    {
        return PatientForm::darkSection('Prestazione', 'Dettagli della prestazione', Heroicon::ClipboardDocumentList)
            ->schema([
                Repeater::make('items')
                    ->hiddenLabel()
                    ->relationship()
                    ->orderColumn('position')
                    ->itemLabel('Trattamento')
                    ->itemNumbers()
                    ->defaultItems(1)
                    ->minItems(1)
                    ->reorderable(false)
                    ->addActionLabel('Aggiungi trattamento')
                    ->addActionAlignment(Alignment::Center)
                    ->addAction(fn (Action $action) => $action->button()->color('primary')->size('md'))
                    ->deleteAction(fn (Action $action) => $action->tooltip('Rimuovi trattamento'))
                    ->columns(12)
                    ->extraAttributes(['class' => 'gest-invoice-lines'])
                    ->schema([
                        Text::make('Compilare le informazioni mancanti')
                            ->color('danger')
                            ->visible(fn (Get $get) => blank($get('description')) || blank($get('unit_price')) || blank($get('quantity')) || blank($get('vat_code')))
                            ->columnSpanFull(),
                        Hidden::make('service_id'),
                        ServiceTitleInput::make('description')
                            ->label('Descrizione')
                            ->showDuration(false)
                            ->required()
                            ->maxLength(1000)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (?string $state, Get $get, Set $set) => self::applyService($state, $get, $set))
                            ->columnSpanFull(),
                        TextInput::make('unit_price')
                            ->label('Prezzo unitario (€)')
                            ->required()
                            ->regex(FormHelpers::PRICE_REGEX)
                            ->validationMessages(['regex' => 'Inserisci un importo valido, es. 50,00'])
                            ->live(onBlur: true)
                            ->columnSpan(3),
                        TextInput::make('quantity')
                            ->label('Quantità')
                            ->required()
                            ->default(1)
                            ->regex('/^\d{1,5}([.,]\d{1,2})?$/')
                            ->live(onBlur: true)
                            ->columnSpan(2),
                        TextInput::make('discount')
                            ->label('Sconto %')
                            ->required()
                            ->default(0)
                            ->regex('/^(100|\d{1,2}([.,]\d{1,2})?)$/')
                            ->validationMessages(['regex' => 'Uno sconto da 0 a 100.'])
                            ->live(onBlur: true)
                            ->columnSpan(2),
                        Select::make('vat_code')
                            ->label('IVA')
                            ->options(VatCode::class)
                            ->default(config('gestionale.invoice.vat_code'))
                            ->required()
                            ->live()
                            ->columnSpan(3),
                        TextInput::make('total')
                            ->label('Totale (€)')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder(fn (Get $get) => self::money(InvoiceCalculator::calculate([[
                                'unit_price' => $get('unit_price'),
                                'quantity' => $get('quantity'),
                                'discount' => $get('discount'),
                            ]], [])['total']))
                            ->columnSpan(2),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(fn (array $data) => [
                        ...$data,
                        'unit_price' => InvoiceCalculator::number($data['unit_price']),
                        'quantity' => InvoiceCalculator::number($data['quantity']),
                        'discount' => InvoiceCalculator::number($data['discount']),
                        'total' => 0, // set by Invoice::recalculate() after saving
                    ]),
            ]);
    }

    private static function taxation()
    {
        return PatientForm::darkSection('Tassazione', 'Informazioni relative alla tua fiscalità', Heroicon::ChartBar)
            ->columns(2)
            ->schema([
                Select::make('tax_regime')
                    ->label('Regime fiscale')
                    ->options(TaxRegime::class)
                    ->default(config('gestionale.invoice.tax_regime'))
                    ->placeholder('Seleziona il tuo regime')
                    ->required(),
                Select::make('pension_fund')
                    ->label('Cassa previdenziale')
                    ->options(PensionFund::class)
                    ->default(config('gestionale.invoice.pension_fund'))
                    ->placeholder('Seleziona la tua cassa previdenziale')
                    ->live(),

                Group::make([
                    Grid::make(12)->schema([
                        TextInput::make('stamp_amount')
                            ->label('Marca da bollo (€)')
                            ->default(config('gestionale.invoice.stamp_amount'))
                            ->regex(FormHelpers::PRICE_REGEX)
                            ->required(fn (Get $get) => (bool) $get('stamp_enabled'))
                            ->disabled(fn (Get $get) => ! $get('stamp_enabled'))
                            ->dehydrated()
                            ->live(onBlur: true)
                            ->helperText('Applicare se la prestazione supera i 77,47 €')
                            ->columnSpan(9),
                        Toggle::make('stamp_enabled')
                            ->label('Applica')
                            ->live()
                            ->inline(false)
                            ->columnSpan(3),
                    ]),
                    Checkbox::make('stamp_charged_to_issuer')
                        ->label('A mio carico (non la addebito al paziente)')
                        ->live(),
                ]),
                Grid::make(12)->schema([
                    TextInput::make('contribution_rate')
                        ->label('Rivalsa/Contributo Integrativo (%)')
                        ->default(config('gestionale.invoice.contribution_rate'))
                        ->regex('/^\d{1,2}([.,]\d{1,2})?$/')
                        ->required(fn (Get $get) => (bool) $get('contribution_enabled'))
                        ->disabled(fn (Get $get) => ! $get('contribution_enabled'))
                        ->dehydrated()
                        ->live(onBlur: true)
                        ->columnSpan(9),
                    Toggle::make('contribution_enabled')
                        ->label('Applica')
                        ->default(config('gestionale.invoice.contribution_enabled'))
                        ->live()
                        ->inline(false)
                        ->columnSpan(3),
                ]),

                Group::make([
                    Checkbox::make('stamp_virtual')
                        ->label('Marca da bollo assolta in maniera virtuale')
                        ->hintIcon(Heroicon::InformationCircle, tooltip: "Se paghi l'imposta di bollo in modo virtuale (autorizzazione dell'Agenzia delle Entrate) invece di applicare il contrassegno sulla fattura."),
                    Checkbox::make('contribution_included')
                        ->label('Includi la rivalsa/contributo nel prezzo della prestazione.')
                        ->default(config('gestionale.invoice.contribution_included'))
                        ->live(),
                    Checkbox::make('withholding_enabled')
                        ->label("Attiva ritenuta d'acconto")
                        ->live()
                        // Proposes the base: fees (+ INPS rivalsa) of the lines entered so far.
                        ->afterStateUpdated(fn (bool $state, Get $get, Set $set) => $state ? $set('withholding_base', self::suggestedWithholdingBase($get)) : null),
                    Grid::make(4)
                        ->visible(fn (Get $get) => (bool) $get('withholding_enabled'))
                        ->schema([
                            Select::make('withholding_type')
                                ->label('Tipo Ritenuta')
                                ->options(WithholdingType::class)
                                ->placeholder('Seleziona il tipo ritenuta'),
                            Select::make('withholding_reason')
                                ->label('Causale Pagamento')
                                ->options(WithholdingReason::class)
                                ->placeholder('Seleziona la causale'),
                            TextInput::make('withholding_rate')
                                ->label('Aliquota (%)')
                                ->default(config('gestionale.invoice.withholding_rate'))
                                ->regex('/^\d{1,2}([.,]\d{1,2})?$/')
                                ->required(fn (Get $get) => (bool) $get('withholding_enabled'))
                                ->live(onBlur: true),
                            TextInput::make('withholding_base')
                                ->label('Base Imponibile (€)')
                                ->default(0)
                                ->regex(FormHelpers::PRICE_REGEX)
                                ->validationMessages(['regex' => 'Inserisci un importo valido, es. 100,00'])
                                ->required(fn (Get $get) => (bool) $get('withholding_enabled'))
                                ->live(onBlur: true)
                                ->suffixAction(
                                    Action::make('recalculateWithholdingBase')
                                        ->icon(Heroicon::ArrowPath)
                                        ->tooltip('Ricalcola dai trattamenti')
                                        ->action(fn (Get $get, Set $set) => $set('withholding_base', self::suggestedWithholdingBase($get))),
                                ),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    private static function bank()
    {
        return PatientForm::darkSection('Coordinate bancarie', "Riferimenti bancarie dell'attività", Heroicon::BuildingLibrary)
            ->collapsed()
            ->columns(4)
            ->schema([
                TextInput::make('bank_name')->label(FormHelpers::optional('Nome banca'))->default(config('gestionale.invoice.bank.name'))->maxLength(255),
                TextInput::make('bank_holder')->label(FormHelpers::optional('Intestatario'))->default(config('gestionale.invoice.bank.holder'))->maxLength(255),
                TextInput::make('iban')
                    ->label(FormHelpers::optional('IBAN'))
                    ->default(config('gestionale.invoice.bank.iban'))
                    ->regex('/^[A-Za-z]{2}\d{2}[A-Za-z0-9 ]{11,40}$/')
                    ->validationMessages(['regex' => 'IBAN non valido.'])
                    ->dehydrateStateUsing(fn (?string $state) => filled($state) ? strtoupper(str_replace(' ', '', $state)) : null),
                TextInput::make('bic')
                    ->label(FormHelpers::optional('BIC/Swift'))
                    ->default(config('gestionale.invoice.bank.bic'))
                    ->regex('/^[A-Za-z0-9]{8}([A-Za-z0-9]{3})?$/')
                    ->dehydrateStateUsing(fn (?string $state) => filled($state) ? strtoupper($state) : null),
            ]);
    }

    private static function other()
    {
        return PatientForm::darkSection('Altro', 'Informazioni aggiuntive alla fatturazione', Heroicon::UserCircle)
            ->collapsed()
            ->schema([
                Repeater::make('causals')
                    ->label(FormHelpers::optional('Causali'))
                    ->simple(TextInput::make('text')->placeholder('Inserisci causale (max 200 caratteri)')->maxLength(200))
                    ->defaultItems(1)
                    ->reorderable(false)
                    ->addActionLabel('Aggiungi')
                    ->addAction(fn (Action $action) => $action->link())
                    ->addActionAlignment(Alignment::End),

                Textarea::make('central_text')
                    ->label(FormHelpers::optional('Dicitura Centrale'))
                    ->default(collect(config('gestionale.invoice.central_texts'))->firstWhere('default', true)['text'] ?? null)
                    ->rows(3)
                    ->maxLength(1000)
                    ->live(debounce: 500)
                    ->helperText(fn (?string $state) => mb_strlen((string) $state).'/1000 caratteri')
                    ->hintAction(
                        Action::make('chooseCentralText')
                            ->label('Scegli Template')
                            ->icon(Heroicon::OutlinedClipboardDocumentList)
                            ->button()
                            ->outlined()
                            ->size('sm')
                            ->modalHeading('Seleziona Template')
                            ->modalWidth('2xl')
                            ->modalSubmitActionLabel('Seleziona')
                            ->schema([
                                Radio::make('template')
                                    ->hiddenLabel()
                                    ->options(collect(config('gestionale.invoice.central_texts'))->mapWithKeys(fn (array $t, int $i) => [
                                        $i => new HtmlString(e($t['name']).(! empty($t['default']) ? ' <span class="gest-badge-default">predefinito</span>' : '')),
                                    ])->all())
                                    ->descriptions(collect(config('gestionale.invoice.central_texts'))->mapWithKeys(fn (array $t, int $i) => [
                                        $i => str($t['text'])->limit(80),
                                    ])->all())
                                    ->required(),
                            ])
                            ->action(fn (array $data, Set $set) => $set('central_text', config("gestionale.invoice.central_texts.{$data['template']}.text"))),
                    ),

                Textarea::make('notes')
                    ->label(FormHelpers::optional('Note'))
                    ->placeholder("Es: Inserisci nota per l'assicurazione...")
                    ->rows(4)
                    ->maxLength(1500)
                    ->live(debounce: 500)
                    ->helperText(fn (?string $state) => mb_strlen((string) $state).'/1500 caratteri')
                    ->hintAction(
                        Action::make('appointmentsReport')
                            ->label('Report appuntamenti')
                            ->button()
                            ->outlined()
                            ->size('sm')
                            ->action(fn (Get $get, Set $set) => self::appendAppointmentsReport($get, $set)),
                    ),
            ]);
    }

    /** Choosing a service of the price list fills price and VAT code of the line. */
    private static function applyService(?string $name, Get $get, Set $set): void
    {
        $service = filled($name) ? Service::query()->active()->where('name', $name)->first() : null;

        $set('service_id', $service?->id);

        if (! $service) {
            return;
        }

        $set('unit_price', FormHelpers::formatPrice($service->price));
        $set('vat_code', $service->vat_code?->value ?? config('gestionale.invoice.vat_code'));

        if (blank($get('quantity'))) {
            $set('quantity', 1);
        }
    }

    /**
     * "Report appuntamenti": adds to the notes the appointments of the patient in the
     * 90 days up to the document date (cancelled and missed ones left out).
     */
    private static function appendAppointmentsReport(Get $get, Set $set): void
    {
        if (blank($get('patient_id'))) {
            Notification::make()->title('Scegli prima il paziente')->warning()->send();

            return;
        }

        $tz = config('gestionale.timezone');
        $until = CarbonImmutable::parse($get('issued_on') ?: today(), $tz)->endOfDay();

        $lines = Appointment::query()
            ->where('patient_id', $get('patient_id'))
            ->whereNotIn('status', [AppointmentStatus::Cancelled, AppointmentStatus::NoShow])
            ->whereBetween('starts_at', [$until->subDays(90)->utc(), $until->utc()])
            ->orderBy('starts_at')
            ->get()
            ->map(fn (Appointment $a) => '- '.$a->starts_at->setTimezone($tz)->format('d/m/Y H:i').($a->title ? ' '.$a->title : ''));

        if ($lines->isEmpty()) {
            Notification::make()->title('Nessun appuntamento negli ultimi 90 giorni')->warning()->send();

            return;
        }

        $report = "Appuntamenti:\n".$lines->implode("\n");
        $set('notes', mb_substr(trim(($get('notes') ? $get('notes')."\n\n" : '').$report), 0, 1500));
    }

    /** Fees of the lines, plus the INPS rivalsa: the usual base of the withholding tax. */
    private static function suggestedWithholdingBase(Get $get): string
    {
        $amounts = InvoiceCalculator::calculate(array_values($get('items') ?? []), [
            'contribution_enabled' => $get('contribution_enabled'),
            'contribution_rate' => $get('contribution_rate'),
            'contribution_included' => $get('contribution_included'),
            'pension_fund' => $get('pension_fund'),
        ]);

        return FormHelpers::formatPrice($amounts['withholding_base']);
    }

    /** Totals for the sticky bar at the bottom of the page. */
    public static function summary(Get $get): array
    {
        $amounts = InvoiceCalculator::calculate(array_values($get('items') ?? []), [
            'contribution_enabled' => $get('contribution_enabled'),
            'contribution_rate' => $get('contribution_rate'),
            'contribution_included' => $get('contribution_included'),
            'pension_fund' => $get('pension_fund'),
            'stamp_enabled' => $get('stamp_enabled'),
            'stamp_amount' => $get('stamp_amount'),
            'stamp_charged_to_issuer' => $get('stamp_charged_to_issuer'),
            'withholding_enabled' => $get('withholding_enabled'),
            'withholding_rate' => $get('withholding_rate'),
            'withholding_base' => $get('withholding_base'),
        ]);

        $rows = [['Prestazione', self::money($amounts['taxable_amount'])]];

        if ($amounts['contribution_amount'] > 0) {
            $rows[] = ['Rivalsa / contributo', self::money($amounts['contribution_amount'])];
        }
        if ($amounts['vat_amount'] > 0) {
            $rows[] = ['IVA', self::money($amounts['vat_amount'])];
        }
        if ($amounts['stamp_charged'] > 0) {
            $rows[] = ['Marca da bollo', self::money($amounts['stamp_charged'])];
        }

        return [
            'rows' => $rows,
            'total' => self::money($amounts['total']),
            'withholding' => $amounts['withholding_amount'] > 0 ? self::money($amounts['withholding_amount']) : null,
            'netDue' => self::money($amounts['net_due']),
            'stampWarning' => ! $get('stamp_enabled') && $amounts['untaxed_amount'] > InvoiceCalculator::STAMP_THRESHOLD,
        ];
    }

    public static function money(float $amount): string
    {
        return number_format($amount, 2, ',', '.').' €';
    }

    private static function date(string $name, string $label): DatePicker
    {
        return DatePicker::make($name)
            ->label($label)
            ->native(false)
            ->displayFormat('d-m-Y')
            ->placeholder('GG-MM-AAAA');
    }

    private static function year(mixed $date): ?int
    {
        return filled($date) ? CarbonImmutable::parse($date)->year : null;
    }
}
