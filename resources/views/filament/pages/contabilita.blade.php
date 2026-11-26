<x-filament-panels::page>
    @php($s = $this->getSummary())

    <div class="gest-accounting" x-data="{ hidden: false }">
        <div class="gest-accounting-cards">
            <div class="gest-month-card">
                <div class="gest-month-card-title">{{ $s['monthLabel'] }}</div>
                <div class="gest-month-card-amount" x-text="hidden ? '•••• €' : @js($this->money($s['month']))">{{ $this->money($s['month']) }}</div>
                <div class="gest-month-card-note">(Mese corrente)</div>
            </div>

            <div class="gest-info-card">
                <div class="gest-info-card-header">
                    <h2>Informazioni generali</h2>
                    <div class="gest-info-card-tools">
                        <button type="button" class="gest-icon-btn" x-on:click="hidden = ! hidden" x-bind:title="hidden ? 'Mostra importi' : 'Nascondi importi'">
                            <x-filament::icon icon="heroicon-s-eye" class="gest-icon gest-accent" />
                        </button>
                        <select wire:model.live="year" class="gest-select gest-outline-select" aria-label="Anno">
                            @foreach ($this->getYears() as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="gest-outline-btn" disabled title="In arrivo">
                            Statistiche <x-filament::icon icon="heroicon-s-chart-bar" class="gest-icon" />
                        </button>
                    </div>
                </div>

                <div class="gest-info-card-grid">
                    <div>
                        <div class="gest-figure-title">Fatturato</div>
                        <div class="gest-figure-sub">{{ $s['documents'] }} documenti emessi</div>
                        <div class="gest-figure gest-figure-indigo" x-text="hidden ? '•••• €' : @js($this->money($s['turnover']))">{{ $this->money($s['turnover']) }}</div>
                        <div class="gest-figure-sub">Da incassare: {{ $s['toCollect'] }}</div>
                    </div>
                    <div>
                        <div class="gest-figure-title">Incassato</div>
                        <div class="gest-figure-sub">{{ $s['payments'] }} pagamenti</div>
                        <div class="gest-figure gest-figure-green" x-text="hidden ? '•••• €' : @js($this->money($s['collected']))">{{ $this->money($s['collected']) }}</div>
                        <div class="gest-figure-sub">{{ number_format($s['collectedShare'], 1, ',', '.') }}% del fatturato</div>
                    </div>
                    <div>
                        <div class="gest-figure-title">Costi</div>
                        <div class="gest-figure-sub">0 voci</div>
                        <div class="gest-figure gest-figure-red" x-text="hidden ? '•••• €' : '0,00 €'">0,00 €</div>
                        <div class="gest-figure-sub">Fatture passive: 0 - Extra: 0</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="gest-tabs" role="tablist">
            @foreach (\App\Filament\Pages\Contabilita::TABS as $key => $label)
                <button type="button" role="tab" wire:click="$set('tab', '{{ $key }}')" @class(['gest-tab', 'gest-tab-active' => $tab === $key])>{{ $label }}</button>
            @endforeach
        </div>

        @if ($tab === 'active')
            {{ $this->table }}
        @else
            <div class="gest-wip-box">
                <x-filament::icon icon="heroicon-o-wrench-screwdriver" class="gest-wip-icon" />
                <div class="gest-wip-title">Work in progress</div>
                <div class="gest-wip-text">La sezione "{{ \App\Filament\Pages\Contabilita::TABS[$tab] }}" non è ancora disponibile.</div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
