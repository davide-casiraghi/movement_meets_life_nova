@extends('layouts.app')

@section('title')@lang('static_pages.treatments.title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">
        @include('partials.pages.treatments.bodywork')
        @include('partials.pages.treatments.movementClasses')
    </div>
@endsection
