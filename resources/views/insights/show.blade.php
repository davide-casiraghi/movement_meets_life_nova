@extends('layouts.app')

@section('content')

    @include('partials.messages')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10">
        @if(!$insight->hasMedia('insight'))
            <h2 class="mt-2 mb-8 text-3xl leading-8 font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">{{ $insight->title }}</h2>
        @endif

        <div class="prose text-gray-500">
            {!! $insight->body !!}
        </div>
    </div>
@endsection
