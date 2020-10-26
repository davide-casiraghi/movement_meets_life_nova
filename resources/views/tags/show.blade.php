@extends('layouts.app')

@section('content')

    <h2 class="text-gray-900 text-3xl mx-4">Tag: {{$tag->tag}}</h2>
    <div>
    @foreach($posts as $post)
        <a href="{{ route('posts.show',$post->id) }}">{{$post->title}}</a>
        <br>
        {{$post->intro_text}}<br><br>
    @endforeach

    </div>
@endsection


