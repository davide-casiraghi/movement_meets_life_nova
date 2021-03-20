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



    {{-- FAQs --}}
    @include('partials.pages.treatments.faq_two_columns', [
          'left' => [
              1 => [
                'question' => "Left, What's the best thing about Switzerland?",
                'answer' =>  "I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.",
              ],
              2 => [
                'question' => "Left, How do you make holy water?",
                'answer' =>  "You boil the hell out of it. Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam aut tempora vitae odio inventore fuga aliquam nostrum quod porro. Delectus quia facere id sequi expedita natus.",
              ],
            ],
          'right' => [
              1 => [
                'question' => "Right, What's the best thing about Switzerland?",
                'answer' =>  "I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.",
              ],
              2 => [
                'question' => "Right, How do you make holy water?",
                'answer' =>  "You boil the hell out of it. Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam aut tempora vitae odio inventore fuga aliquam nostrum quod porro. Delectus quia facere id sequi expedita natus.",
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
