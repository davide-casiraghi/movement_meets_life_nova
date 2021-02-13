@extends('layouts.app')

{{--
    Glossary tooltips loaded in:
    resources/js/vendors/staaky_tipped.js
--}}

@section('jumbotron')
    @if($event->hasMedia('introimage'))
        <div class="bg-fixed relative bg-cover bg-no-repeat" style="background-image: url('{{$event->getMedia('introimage')[0]->getUrl()}}'); ">
            <div class="container mx-auto px-6 py-40 max-w-prose relative z-10">
                <h2 class="text-4xl font-bold mb-2 text-white">
                    {{ $event->title }}
                </h2>

            </div>

            <div class="opacity-25 bg-black flex items-center h-full w-full flex-wrap z-0 top-0 right-0 absolute"></div>
        </div>
        {{--https://www.digitalocean.com/community/tutorials/build-a-beautiful-landing-page-with-tailwind-css--}}
    @endif
@endsection

@section('content')

    @include('partials.messages')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10">
        @if(!$event->hasMedia('introimage'))
            <h2 class="mt-2 mb-8 text-3xl leading-8 font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">{{ $event->title }}</h2>
        @endif

        <div class="prose text-gray-500 mb-10">
            {!! $event->description !!}
        </div>

    </div>
@endsection
