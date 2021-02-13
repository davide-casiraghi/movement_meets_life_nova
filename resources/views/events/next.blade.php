@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto px-8 sm:px-0 mb-10">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-4xl md:text-6xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Events
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                The next events in our agenda
            </p>
        </div>

        <ul>
        @forelse($events as $event)
            {{--@include('partials.pages.blog.post')--}}
            <li>
                <a href="{{route('events.show', $event->id)}}">{{$event->title}}</a>
            </li>
        @empty
            No events found
        @endforelse
        </ul>
    </div>

@endsection
