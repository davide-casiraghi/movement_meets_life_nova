@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        <div class="leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Treatments - Ilan Lev Method
            </h1>
        </div>

        @include('partials.pages.treatments.intro')


        <p class="border-solid box-border text-lg m-0 text-gray-500 mt-20">
            The Ilan Lev method works towards improving human capabilities and removing functional difficulties. The treatment resolves body-circulation issues, relieves pain and skeletal and joint problems.
        </p>


        <div class="">
            In April 2019 I've completed the first Ilan Lev Method training program in Europe and I'm a certified practitioner.
            I give private treatments in Ljubljana, Slovenia.
        </div>

        @include('partials.pages.treatments.bodywork')
        @include('partials.pages.treatments.movementClasses')
        @include('partials.pages.treatments.big_feedbacks')

    </div>

    {{-- Galley --}}
    @include('partials.pages.treatments.treatment_gallery')

    {{-- FAQs --}}
    @include('partials.pages.treatments.faq_two_columns', [
          'left' => [
              1 => [
                'question' => "Why ILM is different from a normal massage?",
                'answer' =>  "A normal massage is directed to fascia and bones <br> In Ilan Lev method our focus is the structure of the receiver the movement goes from the skeleton of the practitioner to the one of the receiver. <br> Everything is attached to the skeleton: muscles, fascia, nervous system, blood system, immune system. <br> We never force, it's a dialogue with mutual.listening.<br> If the tensions were coming out of a bad habit after the massage will come back. The treatment instead, allow the receive to get a better understanding of his/her system addressing sensory motor amnesia and in this way address also bad habits.",
              ],
              2 => [
                'question' => "What is sensory motor amnesia ?",
                'answer' =>  "The more we are stressed somewhere and the less we are able to get feedback for that part of our body. <br> This because the tensions cut off the sensations. <br> So when we have tensions we are not able to identify what is going on and work to release that.",
              ],
              3 => [
                'question' => "I have a fresh injury, can I get a bodywork ?",
                'answer' =>  "Yes, it's gonna be much more slow and minimal compared with an usual bodywork, anyway it can support the process of healing from the injury.",
              ],
            ],
          'right' => [
              1 => [
                'question' => "How much time a treatment lasts ?",
                'answer' =>  "It can last from 1h to 1h and half.",
              ],
              2 => [
                'question' => "How many treatments I should take?",
                'answer' =>  "You can come for the first treatment to meet the method and see if it resonate you. After that I suggest a cycle of 5 treatment, after that we will check the how the condition is changed and decide if continue or not.",
              ],
              3 => [
                'question' => "It is a bodywork good to address back pain ?",
                'answer' =>  "Yes it is.",
              ],
            ],
      ])


    @include('partials.pages.treatments.benefits')



    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">
        <div class="">

            <h2 class="text-xl text-gray-900 font-extrabold tracking-tight sm:text-2xl mt-8 mb-4">
                More info
            </h2>

            <p>
                Please enjoy this video about the method: Youtube >
                To keep updated on my latest articles and special offers you can follow my Facebook page
                More about ILM >
            </p>

        </div>

        <div class="">

            <h2 class="text-xl text-gray-900 font-extrabold tracking-tight sm:text-2xl mt-8 mb-4">
                Extra resources
            </h2>

            <p>
                If you are new to the somatic world I find very interesting and clear this description of somatic education provided by the Rolling Point association in Vienna.

                I think that it can be also helpful this quote:
                Somatic bodywork involves someone else's eyes and senses on your body, to help you find "lost" parts of yourself, areas subject to "sensori-motor amnesia" that only outside pair of hands can help you discover, because they have fallen out of your body image.
                - Tom Meyers -
            </p>

        </div>


        <div class="mt-4 text-xl text-gray-500 leading-8">
            Here is your treatment <br>
            Contact: Davide Casiraghi, +38669627872, davide.casiraghi@gmail.com<br>
            Treatment duration: 60-90 minutes per session<br>
            By appointment<br>
        </div>
    </div>

        {{-- What is the treatment about--}}
        @include('partials.pages.treatments.features')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">
        <div class="">


        </div>

        <div class="">
            Testimonials
        </div>
    </div>

@endsection
