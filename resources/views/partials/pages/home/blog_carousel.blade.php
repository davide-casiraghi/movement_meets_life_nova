{{--
    Carousel with the latest blog posts that have an intro image.
    Three posts visible (two on tablets, one on phones), scrolled with the arrows.
    The slider is initialized in resources/js/vendors/posts_carousel.js
--}}
@if($carouselPosts->isNotEmpty())
    <div class="mt-20 mb-16 mx-auto max-w-[theme(screens.xl)] px-4 sm:px-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-8 w-11/12 mx-auto">
            <div>
                <h2 class="text-4xl tracking-tight leading-10 font-brand text-gray-900 sm:leading-none lg:text-4xl xl:text-5xl">
                    @lang('post.blog_heading')
                </h2>
                {{-- Same style as the other subtitles of the homepage blocks --}}
                <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                    @lang('post.home_carousel_subtitle')
                </p>
            </div>
            <a href="{{ route('posts.blog') }}" class="text-base font-medium text-primary-600 hover:text-primary-500 whitespace-nowrap sm:ml-4">
                @lang('post.all_posts') &rarr;
            </a>
        </div>

        {{-- w-11/12: leaves room for the < > arrows --}}
        <div class="postsCarousel w-11/12 mx-auto">
            @foreach($carouselPosts as $post)
                @php
                    $introImage = $post->getFirstMedia('introimage');
                    $imageUrl = $introImage->hasGeneratedConversion('facebook') ? $introImage->getUrl('facebook') : $introImage->getUrl();
                @endphp
                <div class="px-3">
                    <a href="{{ route('posts.show', $post->slug) }}" class="group block">
                        <div class="aspect-video overflow-hidden rounded-lg shadow-md bg-gray-100">
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $post->introimage_alt ?: $post->title }}"
                                 loading="lazy"
                                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        </div>
                        <h3 class="mt-4 text-lg font-semibold leading-snug text-gray-900 group-hover:text-primary-600">
                            {{ $post->title }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @lang('post.reading_time', ['minutes' => $post->readingTime('minutes')])
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
