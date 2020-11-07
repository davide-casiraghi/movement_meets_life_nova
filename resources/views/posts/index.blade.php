@extends('layouts.app')

@section('content')
    <h2 class="text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
        Blog
    </h2>

    <div class="px-4 py-2 mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">

        @foreach($posts as $post)
            @include('partials.pages.home.blog.block_post')
        @endforeach
    </div>

    <div class="my-5">
        {{ $posts->links() }}
    </div>


@endsection