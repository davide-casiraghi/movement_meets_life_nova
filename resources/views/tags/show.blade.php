@extends('layouts.app')

@section('content')
    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10">
        <h1 class="text-gray-900 text-3xl">Tag: {{$tag->tag}}</h1>
        <div class="">
            @foreach($posts as $post)
                <div class="mb-6">
                    <a class="textLink" href="{{ route('posts.show',$post->id) }}">{{$post->title}}</a>
                    <div class="">
                    {{$post->intro_text}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


