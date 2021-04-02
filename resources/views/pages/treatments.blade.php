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

    @include('partials.pages.treatments.video_ilm_official')

    {{-- Galley --}}
    @include('partials.pages.treatments.treatment_gallery')

    {{-- What is the treatment about--}}
    @include('partials.pages.treatments.features')

    {{-- FAQs --}}
    @include('partials.pages.treatments.faq_two_columns', [
          'left' => [
              1 => [
                'question' => "Why to get a bodywork ?",
                'answer' =>  "Somatic bodywork involves someone else's eyes and senses on your body, to help you find lost parts of yourself, areas subject to sensori-motor amnesia that only outside pair of hands can help you discover, because they have fallen out of your body image. <br>- Tom Meyers -",
              ],
              2 => [
                'question' => "Why ILM is different from a normal massage?",
                'answer' =>  "A normal massage is focused on <b>muscles and soft tissues</b>, in the Ilan Lev method instead the focus is the <b>skeleton</b>. <br> The <b>movement and vibrations</b> spread from the structure of the practitioner to the one of the receiver. <br>
Everything is attached to the skeleton: muscles, fascia, nervous system, blood system, immune system.<br>
We never force, it's a <b>dialogue with mutual listening</b>.<br>
If the tensions were coming out of a bad habit, after the massage they will come back. <br>
An Ilan Lev bodywork instead, allows the receiver to: restore the ability to get feedback from that area, improve the relation between that area and the rest of the body, experience new movement possibilities.",
              ],
              3 => [
                'question' => "What is sensory motor amnesia ?",
                'answer' =>  "The more we are stressed somewhere and the less we are able to get feedback for that part of our body. <br> This because the tensions cut off the sensations. <br> So when we have tensions we are not able to identify what is going on and work to release that.",
              ],
              4 => [
                'question' => "I have a fresh injury, can I get a bodywork ?",
                'answer' =>  "Yes, it's gonna be much more slow and minimal compared with an usual bodywork, anyway it can support the process of healing from the injury.",
              ],
            ],
          'right' => [
              1 => [
                'question' => "How much time a treatment lasts ?",
                'answer' =>  "60-90 minutes per session.",
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


    {{--@include('partials.pages.treatments.benefits')--}}


    {{--
        <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">
            <div class="">

                <h2 class="text-xl text-gray-900 font-extrabold tracking-tight sm:text-2xl mt-8 mb-4">
                    More info
                </h2>

                <p>
                    Please enjoy this video about the method: Youtube >
                    To keep updated on my latest articles and special offers you can follow my Facebook page
                </p>

            </div>

            <div class="">

                <h2 class="text-xl text-gray-900 font-extrabold tracking-tight sm:text-2xl mt-8 mb-4">
                    Extra resources
                </h2>

                <p>
                    If you are new to the somatic world I find very interesting and clear this description of somatic education provided by the Rolling Point association in Vienna.
                </p>

            </div>


            <div class="mt-4 text-xl text-gray-500 leading-8">
                Here is your treatment <br>
                Contact: Davide Casiraghi, +38669627872, davide.casiraghi@gmail.com<br>
                Treatment duration: 60-90 minutes per session<br>
                By appointment<br>
            </div>
        </div>--}}


@endsection
