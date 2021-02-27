<div>
    <h2 class="mb-4">Variants</h2>

    <div class="md:grid md:grid-cols-6 md:gap-4">
        <div class="md:col-span-2">
            <ul wire:sortable="reorder" class="overflow-hidden rounded shadow divide-y">
                @foreach($variants as $variant)
                    <li wire:sortable.item="{{$variant['id']}}" wire:key="{{$variant['id']}}" class="w-64 p-4 bg-gray-300">
                        <div class="flex justify-between">
                            <div class="flex items-center">
                                <div class="cursor-pointer mr-2">
                                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                {{ $variant['title'] }}
                            </div>
                            <div wire:sortable.handle class="cursor-move">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="md:col-span-4 mt-5 md:mt-0">

            <div class="flex items-end">
                <div class="w-full">
                    @include('partials.forms.input', [
                            'label' => "New variant",
                            'name' => 'newVariant.term',
                            'placeholder' => '',
                            'value' => old('newVariant.term'),
                            'required' => false,
                            'disabled' => false,
                            'livewireSupport' => true,
                    ])
                </div>

                <div class="w-20">
                    <button wire:click="saveGlossaryVariant" type="button" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>




