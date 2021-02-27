<div>
    <h2 class="mb-4">Variants</h2>

    <div class="md:grid md:grid-cols-6 md:gap-4">
        <div class="md:col-span-2">
            <ul wire:sortable="reorder" class="overflow-hidden rounded shadow divide-y">
                @foreach($variants as $variant)
                    <li wire:sortable.item="{{$variant->id}}" wire:key="{{$variant->id}}" class="p-4 bg-gray-300">
                        <div class="flex justify-between">
                            <div class="flex items-center">
                                <div wire:click="delete({{ $variant->id }})" class="cursor-pointer mr-2">
                                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                {{ $variant->term }}
                            </div>
                            <div wire:click.prevent="openModal">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>

                            {{--<div wire:sortable.handle class="cursor-move">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                            </div>--}}
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


    {{-- MODAL --}}
    @if($showModal)
        <div class="z-10 inset-0 overflow-y-auto fixed">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!--
                  Background overlay, show/hide based on modal state.

                  Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                  Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <!--
                  Modal panel, show/hide based on modal state.

                  Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                  Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div>
                        <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                            <button wire:click="closeModal" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class=""> {{-- sm:flex sm:items-start --}}

                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-headline">
                                    Edit Variant
                                </h3>

                                @foreach($locales as $key => $locale)
                                    {{--{{$key}} {{$locale['name']}}--}}
                                   <div class="mt-2">
                                        @include('partials.forms.input', [
                                                'label' => $locale['name'], // eg. English, Italian
                                                'name' => 'term_'.$key,
                                                'placeholder' => '',
                                                'value' => old('newTeacher.name'),
                                                'required' => true,
                                                'disabled' => false,
                                                'livewireSupport' => true,
                                        ])
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button wire:click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Save
                            </button>
                            <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

</div>




