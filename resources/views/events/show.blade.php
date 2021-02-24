@extends('layouts.app')

{{--
    Glossary tooltips loaded in:
    resources/js/vendors/staaky_tipped.js
--}}

@section('fb-tags')
    <meta property="og:title" content="{{ $event->title }} - {{ $event->venue->name }} - {{ $event->venue->city }}, {{ $event->venue->country->name }}" />
    @if($event->hasMedia('introimage'))
        <meta property="og:image" content="{{$event->getMedia('introimage')[0]->getUrl()}}" />
    @else
        <meta property="og:image" content="/storage/logo/fb_logo_cigc_red.jpg" />
    @endif
@endsection

@section('jumbotron')
    @if($event->hasMedia('introimage'))
        <div class="bg-fixed relative bg-cover bg-no-repeat" style="background-image: url('{{$event->getMedia('introimage')[0]->getUrl()}}'); ">
            <div class="container mx-auto px-6 py-40 max-w-prose relative z-10 text-white">
                <h2 class="text-4xl font-bold mb-2">
                    {{ $event->title }}
                </h2>

                @include('partials.events.mainInformation')

            </div>

            <div class="opacity-25 bg-black flex items-center h-full w-full flex-wrap z-0 top-0 right-0 absolute"></div>
        </div>
        {{--https://www.digitalocean.com/community/tutorials/build-a-beautiful-landing-page-with-tailwind-css--}}
    @endif
@endsection

@section('content')

    @include('partials.messages')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10 text-gray-500">
        @if(!$event->hasMedia('introimage'))
            <h2>
                {{ $event->title }}
            </h2>

            @include('partials.events.mainInformation')
        @endif

        <div class="prose text-gray-500 mb-10">
            {!! $event->description !!}
        </div>

    </div>
@endsection
