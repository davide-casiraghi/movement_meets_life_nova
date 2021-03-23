@extends('layouts.app')

@section('title'){{$titleQuestion}}@endsection
@section('description'){{$glossaryTerm->definition}}@endsection

@section('fb-tags')
    <!-- Social meta-tags -->
    <x-social-meta
        :title="$titleQuestion"
        :image="$glossaryTerm->hasMedia('introimage') ?
                $glossaryTerm->getMedia('introimage')[0]->getUrl('facebook') :
                '/storage/logo/fb_logo_cigc_red.jpg'"
    />
    <!-- End Social meta-tags -->

{{--    <meta property="og:title" content="{{ $titleQuestion }}" />--}}
{{--    @if($glossaryTerm->hasMedia('introimage'))--}}
{{--        <meta property="og:image" content="{{$glossaryTerm->getMedia('introimage')[0]->getUrl('facebook')}}" />--}}
{{--    @else--}}
{{--        <meta property="og:image" content="/storage/logo/fb_logo_cigc_red.jpg" />--}}
{{--    @endif--}}
@endsection

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


