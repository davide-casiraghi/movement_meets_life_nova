@extends('layouts.app')

@section('title')@lang('static_pages.contact_improvisation.title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Contact Improvisation
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                Contact Improvisation dance is liberating, creative and fun. It’s about exploring movement, balance, weight, physical contact and communication, involving two or more persons at the time.
            </p>
        </div>

        <div class="">
            @include('partials.contents.image',[
                'imageUrl' => 'images/images_pages/contact_improvisation/ecite_tuscania_nicole.jpg',
                'imageThumbnailUrl' => 'images/images_pages/contact_improvisation/ecite_tuscania_nicole.jpg',
                'alt' => 'Ecite 2017 in Tuscania with Nicole Cantik',
                'classes' => 'w-100 sm:w-72 mb-6 sm:mb-0 ml-0 sm:ml-3 float-right',
            ])

            <b>Contact Improvisation</b> is an improvised dance form based on the communication between two moving bodies that are in physical contact and their combined relationship to the physical laws that govern their motion: gravity, momentum, inertia. The body, to open to these sensations, learns to release excess muscular tension and abandon a certain quality of willfulness to experience the natural flow of movement.<br><br>
            Alertness is developed to work in an energetic state of physical disorientation, trusting in one’s basic survival instincts. It is a free play with balance, self-correcting the wrong moves and reinforcing the right ones, bringing forth a physical/emotional truth about a shared moment of movement that leaves the participants informed, centered, and enlivened.<br><br>
            I see CI as a way to re-awake and enjoy fully our sensitivity and playfulness, working on trust, explore curiosity about movement principles out of daily movement patterns.<br>
        </div>

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

        <h2>Resources</h2>

        @include('partials.contents.accordion',[
                'accordionNumber' => '1',
                'elements' => [
                    [
                        'title' => 'Guidelines for the jams',
                        'text' => "
                                    These are the <a href='https://goo.gl/qbwzjY' class='textLink' target='_blank'>guidelines</a> that we use on Sunday Contact Jams in Slovenia.",
                    ],
                    [
                        'title' => 'Guidelines for Musicians during the jams',
                        'text' => "
                                    These ideas have been written to clarify what are the needs of the dancers during a Contact Improvisation Jam.
                                    <br>
                                    The musicians are books to experiment spontaneously with musical forms and ideas to seek, during the dance, a continuous symbiotic exchange with the dancers.
                                    <br>
                                    Each influencing the other and vice versa. <br>

                                    <a href='https://goo.gl/gFVAB4' class='textLink' target='_blank'>Guidelines for musicians ></a>",
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
