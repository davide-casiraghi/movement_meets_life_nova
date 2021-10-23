<div class="testimonialsList my-32 w-11/12 mx-auto"> {{-- w-4/5 means with 80% to have spaces for arrows--}}
    {{--@for($i = 0; $i < 10; $i++)
        <div class="space-y-4 sm:grid sm:grid-cols-3 sm:gap-6 sm:space-y-0 lg:gap-8 p-3">
            <div class="h-0 aspect-w-3 aspect-h-2 sm:aspect-w-3 sm:aspect-h-4">
                <img class="object-cover shadow-lg rounded-lg" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80" alt="">
            </div>
            <div class="sm:col-span-2">
                <div class="space-y-4">
                    <div class="text-lg leading-6 font-medium space-y-1">
                        <h3>Whitney Francis</h3>
                        <p class="text-indigo-600">Copywriter</p>
                    </div>
                    <div class="text-lg">
                        <p class="text-gray-500">Ultricies massa malesuada viverra cras lobortis. Tempor orci hac ligula dapibus mauris sit ut eu. Eget turpis urna maecenas cras. Nisl dictum.</p>
                    </div>
                </div>
            </div>
        </div>
    @endfor--}}

    @foreach($testimonials as $testimonial)
        <div class="my-4 rounded-lg break-inside p-2">
                @include('partials.pages.home.testimonials.slick.block_testimonial')
        </div>
    @endforeach
</div>


