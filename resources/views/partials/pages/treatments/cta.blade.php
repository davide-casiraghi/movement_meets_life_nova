<div class="mx-4 p-4 md:grid md:grid-cols-4 md:gap-4 bg-white my-24">
    <div class="md:col-span-2">
        @include('partials.events.gmap', [
              'venue_name' => "Višja Vibracija",
              'venue_address' => "Cesta Andreja Bitenca, 68",
              'venue_city' => "Ljubljana",
              'venue_country' => "Slovenija",
              'venue_zip_code' => "1000",
        ])
    </div>
    <div class="md:col-span-2 mt-5 md:mt-0 flex">
        <div class="flex flex-grow flex-col">
            <div class="m-auto">
                <div class="mt-4">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        <span class="block">Get a bodywork</span>
                        {{--<span class="block">Want to try a bodywork?</span>--}}
                        <span class="block text-primary-600 mb-2">You can book online</span>
                    </h2>

                   <div class="mt-4">
                       I give private treatments in Ljubljana, Slovenia at <a href="http://www.visja-vibracija.si/" class="textLink" target="_blank">Višja Vibracija</a>.
                   </div>

                </div>
                <div class="mt-10">
                    <a href="{{route('getATreatment.create')}}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        Get a treatment
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{{--
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <div class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            <span class="block">Ready to dive in?</span>
            <span class="block text-primary-600">Start your free trial today.</span>
        </div>



    </div>


</div>
 --}}