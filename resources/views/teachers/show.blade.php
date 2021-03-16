@extends('layouts.app')

@section('content')

    @include('partials.messages')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10 text-gray-500">
        <h1>
            {{ $teacher->name }} {{ $teacher->surname }}
        </h1>
        {{-- Country --}}
        <div class="flex mt-3">
            <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div>{{$teacher->country->name}}</div>
        </div>
        <div class="flex mt-2">
            {{-- Year start practice --}}
            <div>
                <div>Year of starting to practice</div>
                <div>{{ $teacher->year_starting_practice }}</div>
            </div>
            {{-- Year start teach --}}
            <div>
                <div>Year of starting to teach</div>
                <div>{{ $teacher->year_starting_teach }}</div>
            </div>
        </div>
        <div class="flex mt-2">
            {{-- Facebook --}}
            <div class="flex">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                </svg>
                <div><a href="{{ $teacher->facebook }}">Facebook profile</a></div>
            </div>
            {{-- Website --}}
            <div class="flex">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path></svg>
                <div><a href="{{ $teacher->website }}">Website</a></div>
            </div>
        </div>
        {{-- Bio --}}
        <div>
            {{ $teacher->bio }}
        </div>
        {{-- Significant teachers --}}
        <div>
            <h3>Significant teachers</h3>
            <div>
                {{ $teacher->significant_teachers }}
            </div>
        </div>
    </div>

@endsection
