@extends('layouts.app')

@section('title')@lang('static_pages.treatments.title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        {{--<div class="leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Treatments - Ilan Lev Method
            </h1>
        </div>--}}

        @include('partials.pages.treatments.intro')

        {{--
                <div class="">
                    In April 2019 I've completed the first Ilan Lev Method training program in Europe and I'm a certified practitioner.
                    <br>
                    I give private treatments in Ljubljana, Slovenia at <a href="http://www.visja-vibracija.si/" class="textLink">Višja Vibracija</a>.
        </div>
--}}

    </div>


    {{--@include('partials.pages.treatments.big_feedbacks')--}}

    @include('partials.pages.treatments.video_ilm_official')

    {{-- Galley --}}
    @include('partials.pages.treatments.treatment_gallery')

    {{-- What is the treatment about --}}
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
                'answer' =>  "Yes, it's gonna be much more slow and minimal compared with the usual bodywork, anyway, it can support the process of healing from the injury.",
              ],
              5 => [
                'question' => "Why do we need to refresh through movement?",
                'answer' =>  "We are constantly accumulating <b>physical and mental tensions</b>. <br>
                            In the body, this tension presents itself as difficulties in functioning.<br>
                            Can be little pain, or discomfort, or can be bigger like a chronic difficulties.<br>
                            And by the time we notice that we are injured and we don't know how it happened.<br>
                            Just when it starts to destabilize us we notice it.<br>
                            The only way to <b>get rid</b> of these interferences and stuckness in movement and <b>refresh our body</b> is <b>through movement</b>.",
              ],
            ],
          'right' => [
              1 => [
                'question' => "How much time a treatment lasts ?",
                'answer' =>  "60-90 minutes per session.",
              ],
              2 => [
                'question' => "How many treatments I should take?",
                //'answer' =>  "There is no minimum number of sessions that should be taken. Already at the first treatment, we can have some release and improvement of the motor functionalities. Although the first treatment it's something new for the body and it's too early to draw conclusions, and also each client and case is different. I usually suggest planning for 5 sessions within a month. A series of treatments can bring good improvements and a good perspective about the results.",
                //'answer' =>  "You can come for the first treatment to meet the method and see if it resonate with you. I suggest then a cycle of 5 treatment, after that we will check how the condition is changed and decide if continue or not.",
                'answer' =>  "Even if in the first session we may have some release and some good results. To address chronic pain conditions takes a series of treatments. You can come for the first treatment to meet the method and see if it resonate with you. I suggest then a cycle of 5 treatment, after that we will check how the condition is changed and decide if continue or not."
              ],
              3 => [
                'question' => "It is a bodywork good to address back pain ?",
                'answer' =>  "Yes it is.",
              ],
              4 => [
                'question' => "How do I need to dress to receive a treatment ?",
                'answer' =>  "Please bring long, comfortable clothes and some fresh socks for treatment, or it can be barefoot. I recommend not drinking in the hour before. After the treatment, allow 30 minutes without a hectic rush. ",
              ],
              5 => [
                'question' => "How is the treatment process of a bodywork session?",
                'answer' =>  "
                            <ul class='mt-6 space-y-4'>
                                <li class='flex space-x-3'>
                                    <svg class='flex-shrink-0 h-5 w-5 text-green-500' x-description='Heroicon name: solid/check' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                    <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'></path>
                                    </svg>
                                    <span class='text-gray-500'>A conversation about complaints, general health, and mental state.</span>
                                </li>

                                <li class='flex space-x-3'>
                                    <svg class='flex-shrink-0 h-5 w-5 text-green-500' x-description='Heroicon name: solid/check' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                    <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'></path>
                                    </svg>
                                    <span class='text-gray-500'>In comfortable clothing, the client finds a relaxed body position, usually lying down.</span>
                                </li>

                                <li class='flex space-x-3'>
                                    <svg class='flex-shrink-0 h-5 w-5 text-green-500' x-description='Heroicon name: solid/check' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                    <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'></path>
                                    </svg>
                                    <span class='text-gray-500'>Treatment.</span>
                                </li>

                                <li class='flex space-x-3'>
                                    <svg class='flex-shrink-0 h-5 w-5 text-green-500' x-description='Heroicon name: solid/check' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                    <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'></path>
                                    </svg>
                                    <span class='text-gray-500'>The body of the client is treated systematically using various techniques.</span>
                                </li>

                                <li class='flex space-x-3'>
                                    <svg class='flex-shrink-0 h-5 w-5 text-green-500' x-description='Heroicon name: solid/check' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                    <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'></path>
                                    </svg>
                                    <span class='text-gray-500'>Feedback from the client during the treatment to be able to implement wishes immediately.</span>
                                </li>

                                <li class='flex space-x-3'>
                                    <svg class='flex-shrink-0 h-5 w-5 text-green-500' x-description='Heroicon name: solid/check' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                    <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'></path>
                                    </svg>
                                    <span class='text-gray-500'>Final conversation.</span>
                                </li>
                            </ul>",
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

    @include('partials.pages.treatments.cta')

@endsection
