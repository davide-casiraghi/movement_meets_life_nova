@extends('layouts.app')

@section('title')@lang('static_pages.about_me.title')@endsection

@section('content')

    <div class="text-lg max-w-prose mx-auto px-8 lg:px-0 mb-6 mt-6">

        <h1>@lang('static_pages.about_me.title')</h1>

        {{--<p class="mb-3">
            <b>Davide Casiraghi</b> BSc in Physical therapy, BSc in Computer Science, Contact Improvisation dance teacher, Ilan Lev method practitioner, based in Lecco, Italy.
        </p>--}}

        
        
        
        
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

        <p class="mb-3 mt-6">
            @lang('static_pages.about_me.member_of')
        </p>
        <p class="mb-3">
            Passionate free-diver and monofin swimmer he is researching about deep water CI dances and he has been co-organizer of <a class="textLink" href="https://deepwaterdancefestival.altervista.org">Deep Water Dance Festival 2018</a>
        </p>

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
                    [
                        'title' => trans('static_pages.about_me.studies'),
                        'text' => "
                        <ul>
                        <li class='pb-2'>
                            ".trans('static_pages.about_me.studies_universities')."
                        </li>
                        <li class='pb-2'>
                            <h4 class='text-xl font-bold mb-1'>Dance Studies</h4>
                            Contact Improvisation Workshops:<br>
                            Marco Zontini ('10, '11), Roberto Lun (’10, ’11, ’12, ‘13), Nita Little ('13, '14, '15, '16, '21, '25), Javier Curia ('10), Vera de Propris ('13), Bernd Knappe ('12, '12, '13), Thomas Kampe ('12, ’13), Daniel Lepkoff (’14), Itay Iatuv (’14, '15), Yaniv Mintzer (‘16, '19, '25), Joerg Hassman (’16), Adrian Russi (’16), Kirstie Simson (’11, '21), Ester Momblance (’10), Katri Luukkonen(’11), Scott Wells(’11), Alicia Grayson(’11), Ray Chung ('12, '13), Nancy Stark Smith (’14), Martin Keogh (’15, ’16), Benno Voorham (’13), Ezster Gal (’14), Patricia Kuypers (’15), Alyssa Lynes (’14), Eckard Muller (’13), Frey Faust (’14), Angelica Dony (’16, ’17), Leonardo Lambruschini (’16), Jess Curtis(’17), Simone Magnani (’14), Anatolliy Layaskallo ('11), Tim O’Donnell (’10), Riccardo Meneghini (’15), Claus Springborg (’14), Nuria Urcelay Martinez ('18), Asaf Bachrach ('19), Romain Bigé ('19), Leilani Weiss ('20), Ramon Roig ('20), Charley Morrissey ('20)<br>
                        </li>
                        <li class='pb-2'>
                            <h4 class='text-xl font-bold mb-1'>Yoga</h4>
                            2016 - RYT200 Yoga Alliance Certification @ <a class='textLink' href='https://www.hari-om.it' target='_self'>Hari Om</a> - Cascina Bellaria.
                        </li>
                        <li class='pb-2'>
                            <h4 class='text-xl font-bold mb-1'>Free Diving</h4>
                            2015 - Freediving certification <a class='textLink' href='https://www.fipsas.it' target='_self'>FIPSAS</a> PAp1. <br>
                            2016 - Monofin Freediving certification FIPSAS PApm. <br>
                            2016 - Marine memory Sensitive Dance® workshop in Maratea with Claude Coldy.
                        </li>
                        <li class='pb-2'>
                            <h4 class='text-xl font-bold mb-1'>Ilan Lev Method</h4>
                            2017-2019 - <a class='textLink' href='https://www.ilanlev.org' target='_self'>Ilan Lev Method</a> bodywork certification. <br><br>
                            2019 - <a class='textLink' href='https://www.ilanlev.org' target='_self'>Ilan Lev Method</a> movement classes facilitator certification.
                        </li>
                    </ul>",
                    ],
                ]
            ])

        <!--
        <h2 class="mt-6 sm:mt-14 mb-4 text-xl text-primary-600 font-extrabold tracking-tight sm:text-2xl">Web development</h2>

        <p class="mb-3">
            I work at <a href="https://www.agiledrop.com/" class="textLink" target="_blank">Agiledrop</a> as a PHP backend developer with Laravel and Drupal.<br>
        </p>
    -->

<!--
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
-->


    </div>
@endsection
