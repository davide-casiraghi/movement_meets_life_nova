@extends('layouts.app')

@section('title')@lang('static_pages.treatments_learn_more.title')@endsection

@section('content')

    <div class="mx-auto px-8 lg:px-0 mb-14 mt-10 sm:mt-24">  {{-- max-w-2xl --}}
        @include('partials.pages.treatments.bodywork')
        @include('partials.pages.treatments.movementClasses')
    </div>
@endsection
