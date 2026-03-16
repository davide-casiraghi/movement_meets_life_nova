@extends('layouts.app')

@section('title')@lang('static_pages.about_me.title')@endsection

@section('content')

    <div class="text-lg max-w-prose mx-auto px-8 lg:px-0 mb-6 mt-6">

        <h1>@lang('static_pages.about_me.title')</h1>
        
        <div class="mb-3 mx-auto max-w-screen-xl">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="sm:text-left md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <p>
                        @lang('static_pages.about_me.intro')
                    </p>
                    <p class="mb-3 mt-3">
                        @lang('static_pages.about_me.currently_organizing')
                    </p>
                </div>
                <div class="mt-6 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                    <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                        <img class="w-full" src="{{asset('images/static_pages/about_me/davide_portratit_web.jpg')}}" alt="Davide Casiraghi">
                    </div>
                </div>
            </div>
        </div>




        {{--<h2 class="mt-6 sm:mt-14 mb-4 text-xl text-primary-600 font-extrabold tracking-tight sm:text-2xl">Movement</h2>--}}
{{-- 
        <p class="mb-3">
            He is currently co-organizing <b>Contact Improvisation</b> regular jams every tuesday eveving in Milano.
        </p>--}}
        
        
        @include('partials.contents.accordion',[
                'accordionNumber' => '3',
                'elements' => [
                    [
                        'title' => trans('static_pages.about_me.studies'),
                        'text' => trans('static_pages.about_me.studies_universities'),
                    ],
                    [
                        'title' => trans('static_pages.about_me.movement_studies'),
                        'text' => trans('static_pages.about_me.movement_studies_details'),
                    ],
                    [
                        'title' => trans('static_pages.about_me.projects'),
                        'text' => trans('static_pages.about_me.member_of')."<br><br><br>".trans('static_pages.about_me.passionate_free_diver'),
                    ],
                ]
            ])
        
{{--
        @include('partials.contents.accordion',[
                'accordionNumber' => '2',
                'elements' => [
                    [
                        'title' => trans('static_pages.about_me.where_does_my_path_start'),
                        'text' => trans('static_pages.about_me.where_does_my_path_start_description'),
                    ],
                    /*[
                        'title' => 'What are my practices to cultivate my self connection?',
                        'text' => "At the moment I have a daily routine of yoga or ILM movement class.<br>
                                    Almost daily rollerblading.<br>
                                    Sometimes running or swimming.<br>
                                    Regualar weekly contact jam.<br>",
                    ],*/
                    [
                        
                        'title' => trans('static_pages.about_me.what_is_movement_for_me'),
                        'text' => trans('static_pages.about_me.what_is_movement_for_me_description'),
                    ],
                ]
            ])
            
            --}}

        {{--
        <h2 class="mt-6 sm:mt-14 mb-4 text-xl text-primary-600 font-extrabold tracking-tight sm:text-2xl">Web development</h2>

        <p class="mb-3">
            I work at <a href="https://www.agiledrop.com/" class="textLink" target="_blank">Agiledrop</a> as a PHP backend developer with Laravel and Drupal.<br>
        </p>
    --}}

{{--
        @include('partials.contents.accordion',[
                'accordionNumber' => '1',
                'elements' => [
                    [
                        'title' => 'My Dev stack',
                        'text' => "I'm a <b>Drupal Backend and Laravel TALL stack web developer</b>, with more than ten years of experience.<br><br>
                        Currently, I am exploring Drupal 7-8, Laravel 8, Laravel Livewire, Tailwind CSS, PhpUnit.<br>
                                    I'm an active member of <a href='https://stackoverflow.com/users/10075394/davide-casiraghi' class='textLink'>Stackoverflow</a>.<br><br>

                        <b>Education:</b> Bachelor of Science (Informatics), Bachelor in Physical Therapy.<br><br>

                        <b>Degree:</b>
                        2006 BSc in Computer Science at <a href='https://www.unimib.it' class='textLink' target='_blank'>Università Degli Studi di Milano Bicocca</a>, Milano Italia.<br><br>
                        2025 BSc in Physical therapy at <a href='https://www.almamater.si/it' class='textLink' target='_blank'>Università Alma Mater Europea</a>, Koper Slovenia.<br><br>

                        <b>Certification:</b> 2021 Laravel Certification at <a class='textLink' target='_blank' href='https://exam.laravelcert.com/is/davide-casiraghi/certified-since/2021-11-05'>Laravelcert.com</a>.<br><br>
                        ",
                    ],
                ]
            ])
--}}
    </div>
@endsection
