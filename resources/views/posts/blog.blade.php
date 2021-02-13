@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto px-8 sm:px-0">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-4xl md:text-6xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Latest
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
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
