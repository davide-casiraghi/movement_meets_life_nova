@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black" style="quotes: auto;">
            <h1 class="sm:text-4xl md:text-6xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight"  style="line-height: 1.2; quotes: auto;">
                Latest
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-600"  style="line-height: 1.55556; --space-y-reverse:0; quotes: auto;">
                All the latest news from the blog.
            </p>
        </div>

        @forelse($posts as $post)
            @include('partials.pages.blog.post')
        @empty
            No posts found
        @endforelse

        <div class="my-5">
            {{ $posts->links() }}
        </div>

    </div>

@endsection
