@extends('layouts.app')


@section('content')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-6">

        <h2 class="text-gray-900 text-3xl">
            {{$titleQuestion}}
        </h2>

        <div class="mt-6 text-base">
            {{$glossaryTerm->definition}}
        </div>
        <div class="text-sm mt-4">
            {!!$glossaryTerm->body!!}
        </div>


        <div>
        {{--@foreach($posts as $post)
            <a href="{{ route('posts.show',$post->id) }}">{{$post->title}}</a>
            <br>
            {{$post->intro_text}}<br><br>
        @endforeach--}}

        </div>

    </div>
@endsection


