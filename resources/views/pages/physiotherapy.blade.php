@extends('layouts.app')

@section('title')@lang('static_pages.treatments.title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        {{--<div class="leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Treatments - Ilan Lev Method
            </h1>
        </div>--}}

        @include('partials.pages.physiotherapy.intro')

        {{--
                <div class="">
                    In April 2019 I've completed the first Ilan Lev Method training program in Europe and I'm a certified practitioner.
                    <br>
                    I give private treatments in Ljubljana, Slovenia at <a href="http://www.visja-vibracija.si/" class="textLink">Višja Vibracija</a>.
        </div>
--}}

    </div>


    {{--@include('partials.pages.treatments.big_feedbacks')--}}

    {{--@include('partials.pages.treatments.video_ilm_official')--}}

    @include('partials.pages.physiotherapy.therapeutic_treatments.manual_theraphy')
    
    @include('partials.pages.physiotherapy.therapeutic_treatments.therapeutic_exercise')   

    @include('partials.pages.physiotherapy.therapeutic_treatments.massages') 

    {{-- What is the treatment about --}}
    {{--@include('partials.pages.treatments.features')--}}


    

    {{--@include('partials.pages.treatments.benefits')--}}

    @include('partials.pages.treatments.cta')


@endsection
