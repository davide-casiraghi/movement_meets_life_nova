<?php

namespace App\Filament\Pages;

use App\Enums\InvoiceType;
use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Url;

/**
 * Accounting: month and year summary, tabs and the list of issued invoices.
 * Working for now: "Nuova fattura", the summary and the "Fatture Attive" list.
 * The other tabs, costs and statistics are still to be built.
 */
class Contabilita extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $slug = 'contabilita';

    protected static ?string $title = 'Contabilità';

    protected static ?string $navigationLabel = 'Contabilità';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.contabilita';

    public const TABS = [
        'active' => 'Fatture Attive',
        'passive' => 'Fatture Passive',
        'proforma' => 'Proforma',
        'unpaid_sessions' => 'Sedute da saldare',
        'expenses' => 'Spese',
    ];

    #[Url]
    public string $tab = 'active';

    #[Url]
    public ?int $year = null;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('viewAny', Invoice::class) ?? false;
    }

    public function mount(): void
    {
        $this->year ??= (int) now()->year;

        if (! array_key_exists($this->tab, self::TABS)) {
            $this->tab = 'active';
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('newInvoice')
                ->label('Nuova fattura')
                ->url(InvoiceResource::getUrl('create')),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Invoice::query()->with('patient'))
            ->columns([
                TextColumn::make('display_number')
                    ->label('ID')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('year', $direction)->orderBy('number', $direction)),
                TextColumn::make('patient.last_name')
                    ->label('Cliente')
                    ->formatStateUsing(fn (Invoice $record) => $record->patient?->full_name)
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('issued_on')
                    ->label('Data')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('paid')
                    ->label('Pagata')
                    ->badge()
                    ->formatStateUsing(fn (bool $state) => $state ? 'SÌ' : 'NO')
                    ->color(fn (bool $state) => $state ? 'success' : 'danger'),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color('gray'),
                IconColumn::make('ts_status')
                    ->label('Stati')
                    ->state(fn (Invoice $record) => $record->type === InvoiceType::Health)
                    ->icon(fn (bool $state) => $state ? Heroicon::ShieldCheck : null)
                    ->color('gray')
                    ->tooltip(fn (bool $state) => $state ? 'Invio al Sistema TS: non ancora disponibile' : null),
                TextColumn::make('total')
                    ->label('Totale')
                    ->money('EUR', locale: 'it')
                    ->weight('bold')
                    ->sortable(),
            ])
            ->defaultSort('issued_on', 'desc')
            ->searchPlaceholder('Cerca cliente...')
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->emptyStateHeading('Nessuna fattura')
            ->emptyStateDescription('Le fatture che crei con "Nuova fattura" compariranno qui.');
    }

    /** Figures of the summary boxes, for the chosen year (and the current month). */
    public function getSummary(): array
    {
        $year = $this->year ?? (int) now()->year;
        $invoices = Invoice::query()->issuedIn($year)->get(['type', 'total', 'paid', 'issued_on']);

        $signed = fn (Invoice $invoice) => $invoice->type->sign() * (float) $invoice->total;
        $turnover = $invoices->sum($signed);
        $paid = $invoices->where('paid', true);
        $collected = $paid->sum($signed);

        $now = now(config('gestionale.timezone'));
        $month = Invoice::query()->issuedIn((int) $now->year, (int) $now->month)->get(['type', 'total'])->sum($signed);

        return [
            'monthLabel' => ucfirst(Carbon::now(config('gestionale.timezone'))->locale('it')->translatedFormat('F Y')),
            'month' => $month,
            'documents' => $invoices->count(),
            'turnover' => $turnover,
            'toCollect' => $invoices->where('paid', false)->count(),
            'payments' => $paid->count(),
            'collected' => $collected,
            'collectedShare' => $turnover > 0 ? $collected / $turnover * 100 : 0,
        ];
    }

    /** Years with invoices, plus the current one. */
    public function getYears(): array
    {
        return Invoice::query()->distinct()->pluck('year')
            ->push((int) now()->year)
            ->unique()->sortDesc()->values()->all();
    }

    public function money(float $amount): string
    {
        return number_format($amount, 2, ',', '.').' €';
    }
}
