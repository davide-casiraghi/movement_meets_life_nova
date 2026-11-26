@php
    $statePath = $getStatePath();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        class="gest-title-input"
        x-data="{
            open: false,
            state: $wire.$entangle(@js($statePath)),
            services: @js($getServices()),
            get filtered() {
                const q = (this.state ?? '').toString().toLowerCase().trim()
                return this.services.filter((s) => q === '' || s.name.toLowerCase().includes(q))
            },
            choose(service) {
                this.open = false
                $wire.$set(@js($statePath), service.name)
            },
        }"
        x-on:click.outside="open = false"
        x-on:keydown.escape.stop="open = false"
    >
        <x-filament::input.wrapper :valid="! $errors->has($statePath)">
            <x-filament::input
                type="text"
                :id="$getId()"
                x-model="state"
                x-on:focus="open = true"
                x-on:click="open = true"
                x-on:input="open = true"
                autocomplete="off"
                :placeholder="$getPlaceholder()"
                :required="$isRequired()"
            />
        </x-filament::input.wrapper>

        <div x-cloak x-show="open && filtered.length" class="gest-title-suggestions" role="listbox">
            <template x-for="service in filtered" :key="service.id">
                <button type="button" class="gest-title-suggestion" role="option" x-on:click="choose(service)">
                    <span class="gest-title-suggestion-name" x-text="service.name"></span>
                    <span class="gest-title-suggestion-price" x-text="service.price"></span>
                    <span class="gest-title-suggestion-duration" x-text="service.duration"></span>
                </button>
            </template>
        </div>
    </div>
</x-dynamic-component>
