@extends('layouts.app')

@section('title')@lang('static_pages.contact_improvisation.title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Contact Improvisation
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                @lang('static_pages.contact_improvisation.subtitle')
            </p>
        </div>

        <div class="">
            @include('partials.contents.image',[
                'imageUrl' => 'images/images_pages/contact_improvisation/ecite_tuscania_nicole.jpg',
                'imageThumbnailUrl' => 'images/images_pages/contact_improvisation/ecite_tuscania_nicole.jpg',
                'alt' => 'Ecite 2017 in Tuscania with Nicole Cantik',
                'classes' => 'w-100 sm:w-72 mb-6 sm:mb-0 ml-0 sm:ml-3 float-right',
            ])

            @lang('static_pages.contact_improvisation.ci_description')
        </div>

        {{--
        <div class="">
            <h2>Contact Classes in Ljubljana</h2>

            @include('partials.contents.image',[
                'imageUrl' => 'images/images_pages/contact_improvisation/contact-classes-in-ljubljana-pic.jpg',
                'imageThumbnailUrl' => 'images/images_pages/contact_improvisation/contact-classes-in-ljubljana-pic.jpg',
                'alt' => 'Art by Giulia Ravarotto from Dance in the City CI festival in Ljubljana',
                'classes' => 'w-100 sm:w-64 mb-6 sm:mb-0 ml-0 sm:ml-3 float-right',
            ])

            They will start at the end of September and will be co-taught with Daniele Mariuz. <br>
            Further info is coming soon. <br><br>
            The CI classes in Ljubljana for the season 2020-2021 will be at the Ex Stena, in Parmova Ulica, 25. <br><br>

        </div>

        <div class="">
            <h2>Contact Improvisation workshops in Trieste</h2>
            @include('partials.contents.image',[
                'imageUrl' => 'images/images_pages/contact_improvisation/contact-improvisation-trieste-daniele-mariuz.jpg',
                'imageThumbnailUrl' => 'images/images_pages/contact_improvisation/contact-improvisation-trieste-daniele-mariuz.jpg',
                'alt' => 'Daniele Mariuz dancing Contact Impro in TriesteFor the season 2020-2021, we are planning a series of workshops at the Dancing House in Trieste.',
                'classes' => 'w-100 sm:w-64 mb-6 sm:mb-0 ml-0 sm:ml-3 float-right',
            ])
            For further info, you have a look at www.dancinghouse.it or contact Marta Zacchingna.<br><br>
            The first workshop will be on 20 September 2020.<br><br>
        </div>

        <div class="">
            <h2>One to one classes</h2>
            On request, I can offer one to one CI classes focused on your specific needs.
        </div>
         --}}

        <h2>Resources</h2>

        @include('partials.contents.accordion',[
                'accordionNumber' => '1',
                'elements' => [
                    [
                        'title' => trans('static_pages.contact_improvisation.guidelines_jams'),
                        'text' => trans('static_pages.contact_improvisation.guidelines_jams_description'),
                    ],
                    [
                        'title' => trans('static_pages.contact_improvisation.guidelines_musicians'),
                        'text' => trans('static_pages.contact_improvisation.guidelines_musicians_description'),
                    ],
                ]
            ])

    </div>

    {{-- Galley --}}
    @include('partials.pages.contact_improvisation.gallery')


    {{--<div class="mb-10">
        {!! $gallery1Html !!}
    </div>--}}

@endsection
