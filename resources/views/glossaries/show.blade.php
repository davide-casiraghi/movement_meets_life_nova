@extends('layouts.app')

@section('title'){{$titleQuestion}}@endsection
@section('description'){{$glossaryTerm->definition}}@endsection

@section('fb-tags')
    <x-social-meta
        :title="$titleQuestion"
        :image="$glossaryTerm->hasMedia('introimage') ?
                $glossaryTerm->getMedia('introimage')[0]->getUrl('facebook') :
                '/storage/logo/fb_logo_cigc_red.jpg'"
    />
    <meta property="fb:app_id" content="188241685231123" />
@endsection

@section('structured-data')
    {!! $glossaryTerm->toJsonLdScript() !!}
@endsection

@section('content')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-6">

        <h2 class="text-gray-900 text-3xl">
            {{$titleQuestion}}
        </h2>

        <div class="mt-6 text-gray-700 text-lg">
            {{$glossaryTerm->definition}}
        </div>
        <div class="text-gray-500 mt-4 text-lg">
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


