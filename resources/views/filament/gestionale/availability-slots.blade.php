{{-- Free slots of "Trova disponibilità". A click writes start, end and professional in the event form. --}}
<div class="gest-slots">
    @if (! $ready)
        <p class="gest-slots-empty">Scegli una durata per vedere gli orari liberi.</p>
    @else
        <div class="gest-slots-total">{{ $total }} {{ $total === 1 ? 'orario' : 'orari' }}</div>

        @forelse ($groups as $group)
            @if ($group['label'])
                <div class="gest-slots-professional">{{ $group['label'] }}</div>
            @endif

            @forelse ($group['days'] as $day)
                <div class="gest-slots-day">
                    <div class="gest-slots-day-header">
                        <span>
                            <x-filament::icon icon="heroicon-o-calendar" class="gest-slots-day-icon" />
                            {{ $day['label'] }}
                        </span>
                        <span class="gest-slots-day-count">{{ count($day['slots']) }} {{ count($day['slots']) === 1 ? 'orario' : 'orari' }}</span>
                    </div>
                    <div class="gest-slots-grid">
                        @foreach ($day['slots'] as $slot)
                            <button
                                type="button"
                                wire:click="pickAvailabilitySlot(@js($slot['start']), @js($slot['end']), @js($slot['professional']))"
                                @class(['gest-slot', 'gest-slot-selected' => $slot['selected']])>{{ $slot['label'] }}</button>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="gest-slots-empty">Nessun orario libero.</p>
            @endforelse
        @empty
            <p class="gest-slots-empty">Nessun orario libero.</p>
        @endforelse
    @endif
</div>
