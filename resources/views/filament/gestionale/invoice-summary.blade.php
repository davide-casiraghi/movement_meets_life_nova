{{-- Sticky bar at the bottom of "Nuovo documento contabile": totals and buttons. --}}
<div class="gest-invoice-bar">
    <div class="gest-invoice-totals">
        @foreach ($rows as [$label, $amount])
            <div class="gest-invoice-row"><span>{{ $label }}</span><span>{{ $amount }}</span></div>
        @endforeach
        <div class="gest-invoice-row gest-invoice-total"><span>Totale</span><span>{{ $total }}</span></div>
        @if ($withholding)
            <div class="gest-invoice-row"><span>Ritenuta d'acconto</span><span>- {{ $withholding }}</span></div>
            <div class="gest-invoice-row gest-invoice-total"><span>Netto a pagare</span><span>{{ $netDue }}</span></div>
        @endif
        @if ($stampWarning)
            <div class="gest-invoice-warning">L'importo senza IVA supera 77,47 €: va applicata la marca da bollo.</div>
        @endif
    </div>
    <div class="gest-invoice-actions">
        <a href="{{ \App\Filament\Pages\Contabilita::getUrl() }}" class="gest-invoice-back">
            <x-filament::icon icon="heroicon-o-arrow-left" class="gest-icon" /> Indietro
        </a>
        <x-filament::button type="submit" wire:loading.attr="disabled" wire:target="create">Crea documento</x-filament::button>
    </div>
</div>
