

<div>
    {{--<div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <select id="tabs" name="tabs" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
            <option>My Account</option>
            <option>Company</option>
            <option selected>Team Members</option>
            <option>Billing</option>
        </select>
    </div>--}}

    <div class="text-gray-700 text-sm font-medium mt-8">
        Translations
    </div>

    <div class="hidden sm:block mt-2">
        <nav class="flex space-x-4" aria-label="Tabs">
            @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)

                <div class="flex w-10 h-10 text-sm font-medium rounded-md bg-gray-100 text-gray-500 hover:text-gray-700 @if(App::isLocale($key)) border-solid border-4 border-indigo-200 @endif">
                    <a href="#" class="m-auto">
                        {{$key}}
                    </a>
                </div>
            @endforeach



           {{-- <a href="#" class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                Company
            </a>
            <!-- Current: "bg-gray-100 text-gray-700", Default: "text-gray-500 hover:text-gray-700" -->
            <a href="#" class="bg-gray-100 text-gray-700 px-3 py-2 font-medium text-sm rounded-md" aria-current="page">
                Team Members
            </a>
            <a href="#" class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                Billing
            </a>--}}
        </nav>
    </div>
</div>
