@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-3xl md:text-5xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Treatments - Ilan Lev Method
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                The Ilan Lev method works towards improving human capabilities and removing functional difficulties. The treatment resolves body-circulation issues, relieves pain and skeletal and joint problems.
            </p>
        </div>

        <div class="mt-4 text-xl text-gray-500 leading-8">
            The Ilan Lev Method (ILM) is a revolutionary form of hands-on bodywork that addresses body aches, pains, and movement imbalances caused by physical or emotional strain.
        </div>
        
        <div class="">
            In April 2019 I've completed the first Ilan Lev Method training program in Europe and I'm a certified practitioner.
            I give private treatments in Ljubljana, Slovenia.
        </div>


        {{-- Ilan Lev Method Bodywork --}}
        <h2 class="text-xl text-gray-900 font-extrabold tracking-tight sm:text-2xl mt-8 mb-4">
            Ilan Lev Method Bodywork
        </h2>

        <div class="">
            During a session, the practitioner brings to the body of the receiver a wide variety of movements, vibrations, playful provocations. These create the environment in which the body's natural ability to heal itself can arise, we discover an optimal range of motion, efficiency of effort, and a new understanding of ourselves.
            This allows new physical pathways and coordinations to emerge or become clearer, old habits to be thrown out, and physical and emotional trauma to be released.
            In this way, the movement returns to parts of the body where communication was cut-off or stopped due to injury, pain, or emotional issues. And the dialogue within the whole system is restored.
        </div>
        
        <div class="text-left my-4">
            <blockquote class=" text-base italic text-gray-500">
                "I find Ilan's work an amazing gift to dancers and people alike. His work helps the body's own regeneration. It brings movement to blocked areas in the body, it comes with positive energy and a sense of joy, it can help quicker recovery from "fresh injuries" as well as heal ״old״ ones... It helped me to become more efficient with my movement and gave me a more balanced body... His work is intelligent, thoughtful, considerate, and serves as a constant research method for growth, for Ilan himself as well as for those he works with."
            </blockquote>
            <div class="text-md text-primary-500 font-bold mt-3">
                - Maestro Ohad Naharin, Choreographer -Artistic Director of Batsheva Dance Company -
            </div>
        </div>

        <div class="text-left my-4">
            <blockquote class=" text-base italic text-gray-500">
                "The doctors in San Diego have recommended that I go to an urgent operation...after surviving 20-hours of a horrible long-distance flight, from the West Coast to Tel-Aviv, I met my old friend Ilan Lev. Within two-three weeks I went back to conduct the symphonic orchestra in San Diego... To the great surprise of the hospital doctors there...They could not believe the 'miracle' that has just occurred."
            </blockquote>
            <div class="text-md text-primary-500 font-bold mt-3">
                - Maestro Yoav Talmi, Conductor - Music Director of Orchestre Symphonique de Quebec, Canada -
            </div>
        </div>


        {{-- Movement classes according to the Ilan Lev Method --}}
        <div class="">
            <h2 class="text-xl text-gray-900 font-extrabold tracking-tight sm:text-2xl mt-8 mb-4">
                Movement classes according to the Ilan Lev Method
            </h2>

            <p>
                The classes are made to improve the inner body dialogue and develop our functioning abilities out of the motion of inner listening and self pulsating.
                In these group classes, the participants are laying on the floor, sitting or moving. The class process is refreshing, intriguing and increasing the body's vitality. Through various images, we learn to break through functional patterns that we have collected over the years, with the understanding that this is how the deepest learning takes place.

                The activity is intended for all those who want to improve their functioning abilities.
            </p>
        </div>

    </div>



    {{-- FAQs --}}
    @include('partials.pages.treatments.faq_two_columns')



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


        {{-- What is the treatment about--}}

    <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">What the treatment is about ?</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        A better way to send money
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        Lorem ipsum dolor sit amet consect adipisicing elit. Possimus magnam voluptatum cupiditate veritatis in accusamus quisquam.
                    </p>
                </div>

                <div class="mt-10">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: outline/globe-alt -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-medium text-gray-900">
                                    Release
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Releases physical and mental tensions
                                </dd>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: outline/scale -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-medium text-gray-900">
                                    Refine
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Refining perceptions and sensitivity
                                </dd>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: outline/lightning-bolt -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-medium text-gray-900">
                                    Enhance
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Awaken and enhance the body's motor functions and activate the senses
                                </dd>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: outline/annotation -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-medium text-gray-900">
                                    Remove
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Remove obstacles in movements and functional difficulties
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>


        <div class="">


        </div>
        
        <div class="">
            Testimonials
        </div>
    </div>

@endsection
