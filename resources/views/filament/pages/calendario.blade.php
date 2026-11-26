<x-filament-panels::page>
    @vite('resources/js/gestionale-calendar.js')

    @php
        $professionals = \App\Models\User::role(\App\Models\User::PHYSIOTHERAPIST_ROLE)->orderBy('email')->pluck('email', 'id');
    @endphp

    <div
        class="gest-calendar"
        x-data="gestionaleCalendar({ $wire, initialView: 'timeGridWeek' })"
    >
        <div class="gest-calendar-toolbar">
            <div class="gest-calendar-toolbar-left">
                <x-filament::button
                    icon="heroicon-o-share"
                    icon-position="after"
                    tooltip="In arrivo: calendari condivisi con i colleghi"
                    disabled
                >
                    Aggiungi collega
                </x-filament::button>

                <button type="button" class="gest-btn-dark" x-on:click="today()">Oggi</button>

                <button type="button" class="gest-icon-btn" x-on:click="prev()" aria-label="Periodo precedente">
                    <x-filament::icon icon="heroicon-o-chevron-left" class="gest-icon" />
                </button>
                <button type="button" class="gest-icon-btn" x-on:click="next()" aria-label="Periodo successivo">
                    <x-filament::icon icon="heroicon-o-chevron-right" class="gest-icon" />
                </button>
            </div>

            <h2 class="gest-calendar-title" x-text="title"></h2>

            <div class="gest-calendar-toolbar-right">
                @if ($professionals->count() > 1)
                    <select class="gest-select" x-model="professional" x-on:change="refetch()" aria-label="Professionista">
                        <option value="">Tutti i professionisti</option>
                        @foreach ($professionals as $id => $email)
                            <option value="{{ $id }}">{{ $email }}</option>
                        @endforeach
                    </select>
                @endif

                <label class="gest-check">
                    <input type="checkbox" x-model="showCancelled" x-on:change="refetch()">
                    Mostra annullati
                </label>

                <select class="gest-select" x-bind:value="view" x-on:change="changeView($event.target.value)" aria-label="Vista">
                    <option value="timeGridDay">Giorno</option>
                    <option value="timeGridWeek">Settimana</option>
                    <option value="dayGridMonth">Mese</option>
                    <option value="listWeek">Programma</option>
                </select>

                <x-filament::button icon="heroicon-o-plus" x-on:click="$wire.mountAction('createEvent')">
                    Nuovo evento
                </x-filament::button>
            </div>
        </div>

        <div class="gest-calendar-body" wire:ignore>
            <div x-ref="calendar"></div>
        </div>
    </div>
</x-filament-panels::page>
