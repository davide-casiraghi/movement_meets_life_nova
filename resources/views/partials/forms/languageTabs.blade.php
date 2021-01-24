

<div x-data="{translationActive: 0}">

    <div class="text-gray-700 text-sm font-medium mt-8">
        Translations
    </div>

    {{--Tabs buttons --}}
    <div class="hidden sm:block mt-2">
        <nav class="flex space-x-4" aria-label="Tabs">
            @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)

                <div class="flex w-10 h-10 text-sm font-medium rounded-md bg-gray-100 text-gray-500 hover:text-gray-700
                        @if(App::isLocale($key)) border-solid border-4 border-indigo-200 @endif"
                        x-on:click.prevent="translationActive = {{$loop->index}}"
                        >
                    <div class="m-auto">
                        {{$key}}
                    </div>
                </div>
            @endforeach
        </nav>
    </div>

    <div class="bg-black bg-opacity-10 border border-black -mt-px">
        <div class="p-4 space-y-2" x-show.transition.in="translationActive === 0">
            <h2 class="text-2xl">Panel 1 Using x-show</h2>
            <p>Panel 1 content</p>
        </div>
        <div class="p-4 space-y-2" x-show.transition.in="translationActive === 1">
            <h2 class="text-2xl">Panel 2 Using x-show.transition</h2>
            <p>Panel 2 content</p>
        </div>
        <div class="p-4 space-y-2" x-show.transition.in="translationActive === 2">
            <h2 class="text-2xl">Panel 3 Using x-transition</h2>
            <p>Panel 3 content</p>
        </div>
    </div>




</div>

