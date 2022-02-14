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

    <div class="text-lg max-w-prose mx-auto mb-6 mt-6 easyRead px-8 md:px-0">

        <h2 class="text-gray-900 text-3xl">
            {{$titleQuestion}}
        </h2>

        <div class="font-avenir text-2xl leading-9 text-gray-700 mb-5">
            {{$glossaryTerm->definition}}
        </div>

        <div class="easyRead font-avenir text-gray-900 text-xl mb-10 leading-9">
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


