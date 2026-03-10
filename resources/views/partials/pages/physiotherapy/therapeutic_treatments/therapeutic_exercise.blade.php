
<div class="mt-8 mx-auto max-w-screen-xl p-4 sm:mt-12 sm:px-6 md:mt-20 xl:mt-24">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left lg:col-start-7 lg:row-start-1">
            <h3 class="mt-1 text-4xl tracking-tight leading-10 font-brand text-gray-900 sm:leading-none sm:text-6xl lg:text-4xl xl:text-5xl">
                @lang('static_pages.physiotherapy.offers.exercises')
            </h3>
            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                @lang('static_pages.physiotherapy.offers.exercises_description')
            </p>
            {{-- 
            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                <div class="rounded-md shadow">
                    <a href="{{route('staticPages.contactImprovisation')}}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:border-primary-700 focus:ring-primary transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        @lang('static_pages.home.blocks.contact.more_about_ci')
                    </a>
                </div>
            </div>
            --}}
        </div>
        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center lg:col-start-1 lg:row-start-1">
            <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                <img class="w-full" src="{{asset('images/static_pages/physiotherapy/exercise.jpg')}}" alt="Therapeutic exercise">
            </div>
        </div>
    </div>
</div>
