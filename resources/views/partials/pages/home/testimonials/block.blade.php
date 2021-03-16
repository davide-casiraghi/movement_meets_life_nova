

{{-- Inspiration https://mailcoach.app/ --}}
<div class="mt-10">
    <h2 class="text-center mb-10 text-2xl">Testimonials</h2>

    <div class="lg:grid lg:grid-cols-3 lg:gap-4 px-4 lg:px-0 items-stretch justify-center">
        @foreach($testimonials as $testimonial)
            <div class="@if($loop->iteration % 2 == 0) mt-8 @endif">
                @include('partials.pages.home.testimonials.block_testimonial')
            </div>
        @endforeach
    </div>
</div>

