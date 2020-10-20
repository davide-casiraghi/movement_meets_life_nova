@extends('layouts.app')

@section('content')
    <div class="px-4 py-2 mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
        @foreach($posts as $post)
            @include('partials.home.blog_post')
        @endforeach
    </div>

    <div class="my-5">
        {{ $posts->links() }}
    </div>


@endsection