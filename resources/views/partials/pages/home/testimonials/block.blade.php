

{{-- Inspiration https://mailcoach.app/ --}}

<div class="grid grid-cols-3 items-stretch justify-center gap-4 | md:gap-8">
    @foreach($testimonials as $testimonial)
        @include('partials.pages.home.testimonials.block_testimonial')
    @endforeach
</div>
