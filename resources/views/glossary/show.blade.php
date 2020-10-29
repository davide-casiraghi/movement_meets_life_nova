@extends('layouts.app')

@section('javascript-document-ready')
    @parent

    $('.has-glossary-term').each(function (i) {
        var termId = "glossary-term-"+i;
        var definitionId = "glossary-definition-"+i;

        Tipped.create(termId, { //id of the element on which display the tooltip on hover
            inline: definitionId, //id of the content of the tooltip
            skin: 'light',
            radius: false,
            padding: false,
            position: 'topleft',
            size: 'large'
        });

    });



    Tipped.create('#demo-html', { //id of the element  on which display the tooltip on hover
        inline: 'thayer-tooltip-content', //id of the content of the tooltip
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


