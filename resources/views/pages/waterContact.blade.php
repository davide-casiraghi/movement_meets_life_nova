@extends('layouts.app')

@section('title')@lang('static_pages.water_contact.title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                @lang('static_pages.water_contact.title')
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                @lang('static_pages.water_contact.intro')
            </p>
        </div>

        <div class="">
            @include('partials.contents.image',[
                'imageUrl' => 'images/static_pages/water_contact/deepwater_logo.png',
                'imageThumbnailUrl' => 'images/static_pages/water_contact/deepwater_logo.png',
                'alt' => 'Deepwater festival logo',
                'classes' => 'w-100 sm:w-72 mb-6 sm:mb-0 ml-0 sm:ml-3 float-right',
            ])

            @lang('static_pages.water_contact.text_1')
            <br> <br>

            @lang('static_pages.water_contact.text_2')
            <br><br>
            @lang('static_pages.water_contact.text_3')
        </div>

    </div>

    {{-- Galley --}}
    <div class="mb-10">
        @include('partials.pages.water_contact.gallery')
    </div>


@endsection
