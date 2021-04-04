@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Water Contact
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                Surrended to the water element, trusting in the support we can receive from it, we can find space in our joints relating to gravity in a new way. This is the place where we meet and our dance begin.
            </p>
        </div>

        <div class="">
            @include('partials.contents.image',[
                'imageUrl' => 'images/static_pages/water_contact/deepwater_logo.png',
                'imageThumbnailUrl' => 'images/static_pages/water_contact/deepwater_logo.png',
                'alt' => 'Deepwater festival logo',
                'classes' => 'w-100 sm:w-72 mb-6 sm:mb-0 ml-0 sm:ml-3 float-right',
            ])

            Since 2014 I'm getting more and more into the research about how to bring Contact Improvisation dance in the water environment.
            The experimentation had taken place in thermal pools, in the sea and Y-40 pool combining tools from many practices such as Contact Improvisation, water bodywork, yoga, relaxation, and somatic techniques.
            <br> <br>

            I'm one of the organizers of the first Deep Water Dance Festival: deepwaterdancefestival.altervista.org
            Deep Water Dance Festival is a meeting where people share their knowledge of dance and freediving in the Italian world’s deepest pool, the Y-40.<br>
            The goal of the meeting is to practice freediving, dance, contact improvisation, watsu, yoga, relaxation, video making, living together in the same house for four days and participating in all these collective research activities. <br>
            The festival is for certificated freedivers who want to try deep underwater contact improvisation, watsu and water dance.<br> <br>

            These photos and videos document the research about dancing Contact Improvisation in shallow and in deep water at the depth of 10 meters.
        </div>

    </div>

    {{-- Galley --}}
    <div class="mb-10">
        @include('partials.pages.water_contact.gallery')
    </div>


@endsection
