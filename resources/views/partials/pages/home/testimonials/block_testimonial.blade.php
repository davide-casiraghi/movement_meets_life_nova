<blockquote class="col-span-3 md:col-span-1 rounded-md shadow-xl overflow-hidden bg-white ">
    <div class="flex-grow flex items-center px-12 py-6 text-xl leading-relaxed text-dark-800">
        <p class="">
            {{$testimonial->feedback_short}}
            <mark class="px-1 bg-orange-100 text-dark-800">It’s a breath of fresh air</mark>
        </p>
    </div>

    <footer class="z-20 px-12 py-3 bg-gray-200">
        <a href="{{route('testimonials.show', $testimonial->id)}}" target="_blank" rel="noopener" class="flex items-center group">
                <span class="mr-3 w-12 h-12 rounded-full overflow-hidden shadow">
                    <img alt="{{$testimonial->name}} {{$testimonial->surname}} avatar" class="w-12 h-12 object-cover rounded-full overflow-hidden" src="{{$testimonial->getMedia('photo')->first()->getUrl('thumb')}}">
                </span>
            <span class="leading-snug">
                <span class="block font-semibold uppercase tracking-widest | group-hover:text-dark-700">{{$testimonial->name}} {{$testimonial->surname}}</span>
                <span class="block text-xs text-dark-500">{{$testimonial->profession}}, {{$testimonial->country->name}}</span>
            </span>
        </a>
    </footer>
</blockquote>
