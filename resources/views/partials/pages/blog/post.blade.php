<li
        class="border-gray-400 border-solid border-0 box-border leading-6 py-12 text-left text-black"
        style="list-style: outside none none; quotes: auto;"
>
    <article class="xl:grid xl:items-baseline xl:grid-cols-4 border-solid box-border text-left" style="list-style: outside none none; quotes: auto;">
        <dl class="border-gray-400 border-0 leading-6 m-0 text-black" style="list-style: outside none none; quotes: auto;">
            <dt class="sr-only border-solid box-border text-left" style="list-style: outside none none; quotes: auto;">
                Published on
            </dt>
            <dd class="border-solid box-border font-medium text-base leading-normal text-left text-gray-600" style="list-style: outside none none; quotes: auto;">
                <time datetime="2021-02-01T13:35:00.0Z" class="border-gray-400 border-0 font-medium leading-6 text-gray-600" style="list-style: outside none none; quotes: auto;">
                    {{$post->created_at->format('M j, Y')}}
                </time>
            </dd>
        </dl>
        <div class="xl:col-span-3 border-gray-400 border-0 leading-6 text-black" style="--space-y-reverse:0; list-style: outside none none; quotes: auto;">
            <div class="border-solid box-border text-left" style="list-style: outside none none; quotes: auto;">
                <h2 class="border-gray-400 border-0 font-bold text-2xl m-0 text-black tracking-tight" style="line-height: 1.33333; list-style: outside none none; quotes: auto;">
                    <a href="{{route('posts.show', $post->id)}}" class="bg-transparent border-solid box-border cursor-pointer text-2xl text-left text-gray-900" style="text-decoration: inherit; line-height: 1.33333; list-style: outside none none; quotes: auto;">
                        {{$post->title}}
                    </a>
                </h2>
                <div class="border-gray-400 border-0 text-base max-w-none text-gray-600" style="line-height: 1.75; --space-y-reverse:0; list-style: outside none none; quotes: auto;"
                >
                    <p class="border-solid box-border leading-7 mx-0 my-5 text-left" style="list-style: outside none none; quotes: auto;">
                        {{$post->intro_text}}

                        {{--{{ \Illuminate\Support\Str::limit($string, 150, $end='...') }}--}}

                        {{--
                        We started working with
                        <a href="https://twitter.com/david_luhr" class="bg-transparent border-gray-400 border-0 cursor-pointer text-left text-gray-900 underline" style="list-style: outside none none; quotes: auto;">
                            David Luhr
                        </a>
                        last summer on a project-by-project basis to help us develop a Figma
                        version of
                        <a href="https://tailwindui.com" class="bg-transparent border-gray-400 border-0 cursor-pointer text-left text-gray-900 underline" style="list-style: outside none none; quotes: auto;"
                        >Tailwind UI</a
                        >
                        <em
                                class="border-gray-400 border-0 leading-7 text-gray-600 italic"
                                style="list-style: outside none none; quotes: auto;"
                        >(almost ready!)</em
                        >, as well as to leverage his accessibility expertise when building
                        Tailwind UI templates, ensuring we were following best practices and
                        delivering markup that would work for everyone, no matter what tools
                        they use to browse the web.
                        --}}
                    </p>

                </div>
            </div>
            <div
                    class="border-solid box-border font-medium text-base leading-normal text-left"
                    style="--space-y-reverse:0; list-style: outside none none; quotes: auto;"
            >
                <a href="{{route('posts.show', $post->id)}}" class="bg-transparent border-gray-400 border-0 cursor-pointer leading-6 text-cyan-600 hover:text-cyan-700" aria-label='Read "Welcoming David Luhr to Tailwind Labs"' style="text-decoration: inherit; list-style: outside none none; quotes: auto;">
                    Read more →
                </a>
            </div>
        </div>
    </article>
</li>