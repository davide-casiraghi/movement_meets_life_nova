@extends('layouts.app')

@section('javascript-document-ready')
    @parent
    Tipped.create('#demo-html', {
        inline: 'thayer-tooltip-content',
            skin: 'light',
            radius: false,
            padding: false,
            position: 'topleft',
            size: 'large'
    });
@stop

@section('content')

    <h2 class="text-gray-900 text-3xl mx-4">Term: {{$glossaryTerm->term}}</h2>

    <div>
        {{$glossaryTerm->definition}}
    </div>
    <br>
    <div>
        {!!$glossaryTerm->body!!}
    </div>


    <div>
    {{--@foreach($posts as $post)
        <a href="{{ route('posts.show',$post->id) }}">{{$post->title}}</a>
        <br>
        {{$post->intro_text}}<br><br>
    @endforeach--}}

    </div>
@endsection


