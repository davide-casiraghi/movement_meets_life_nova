
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
                <a data-fancybox href="https://www.youtube.com/embed/o1FQhUu5W7o">
                    <img class="w-full" src="{{asset('images/static_pages/hp/contact_improvisation_small.jpg')}}" alt="Contact Improvisation class in Slovenia Slovenija">
                    {{--<iframe width="450" height="300" src="https://www.youtube.com/embed/MelWoO9J3E8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
                    <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                        <svg class="h-20 w-20 text-primary-500" fill="currentColor" viewBox="0 0 84 84">
                            <circle opacity="0.9" cx="42" cy="42" r="42" fill="white" />
                            <path d="M55.5039 40.3359L37.1094 28.0729C35.7803 27.1869 34 28.1396 34 29.737V54.263C34 55.8604 35.7803 56.8131 37.1094 55.9271L55.5038 43.6641C56.6913 42.8725 56.6913 41.1275 55.5039 40.3359Z" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
