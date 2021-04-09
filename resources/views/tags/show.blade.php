@extends('layouts.app')

@section('content')
    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10">
        <h1 class="text-gray-900 text-3xl"># {{$tag->tag}}</h1>
        <div class="mb-12 text-lg text-gray-500">
            All the articles tagged with #{{$tag->tag}}.
        </div>
        <div class="mb-20">
            @foreach($posts as $post)
                <div class="mb-8">
                    <a class="textLink" href="{{ route('posts.show',$post->slug) }}">{{$post->title}}</a>
                    <div class="">
                    {{$post->intro_text}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


