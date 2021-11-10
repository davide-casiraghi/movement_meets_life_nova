@extends('layouts.app')

@section('title')@lang('static_pages.about_me.title')@endsection

@section('content')

    <div class="text-lg max-w-prose mx-auto px-8 lg:px-0 mb-6 mt-6">

        <h1>About me</h1>

        <p class="mb-3">
            <b>Davide Casiraghi</b> (BSc) in Computer Science, Senior IT Web Developer, Contact Improvisation dance teacher, Ilan Lev method practitioner, based in Slovenia.<br>
            He is co-creator with Nayeli Spela Peterlin of <a href="https://www.moave.si" class="textLink" target="_blank">Moave - Psychology in movement</a>.
        </p>

        <h2 class="mt-6 sm:mt-14 mb-4 text-xl text-primary-600 font-extrabold tracking-tight sm:text-2xl">Movement</h2>

        <p class="mb-3">
            He is currently giving <b>Contact Improvisation</b> regular classes and <b>Ilan Lev method</b> bodyworks in Ljubljana.
        </p>

        <p class="mb-3">
            Member of the <b>Round Robin Project</b> that has the aim to create tools for global networking of the worldwide Contact Improvisation community. He is web designer, developer and technical manager of the
            <a class="textLink" target="_self" href="https://www.ciglobalcalendar.net">Contact Improvisation Global Calendar (CIGG).</a><br>
            Previously from 2010 to 2018 webmaster of the <b>Contact Improvisation Italian website</b> - www.contactimprov.it (now closed)
        </p>
        <p class="mb-3">
            Passionate free-diver and monofin swimmer he is researching about deep water CI dances and he has been co-organizer of <a class="textLink" href="https://deepwaterdancefestival.altervista.org">Deep Water Dance Festival 2018</a>
        </p>

        @include('partials.contents.accordion',[
                'accordionNumber' => '2',
                'elements' => [
                    [
                        'title' => 'Where does my path of movement awareness start?',
                        'text' => "I'm a twin brother, when somebody asks me when did I start to practice Contact Improvisation, I could answer, from day 0 of my life.<br>
                        For the most of people life start as a solo, in a space that our mother hold for us.<br>
                        There I was floating in a warm liquid and I was relating with another person, my brother Alessio.<br>
                        For 9 months we shared the same space, his presence there was strongly affecting my experience of life and mine for him too.<br><br>

                        Years later, at the age of 27, passing trough a moment of life crisis, I attended a Contact Improvisation workshop and I discovered that I was living mostly dissociate by my body and my emotions.<br>
                        And from that moment I'm in love with self awareness practices.<br>
                        I live them as a way to care my personal integrity.<br>
                        When I feel connected with myself and I listed yo my body, I'm more productive, more able to listen to others, more emphatic, I find more pleasure in what I'm doing, I respect my body, I don't get sick.<br>",
                    ],
                    [
                        'title' => 'What are my practices to cultivate my self connection?',
                        'text' => "At the moment I have a daily routine of yoga or ILM movement class.<br>
                                    Almost daily rollerblading.<br>
                                    Sometimes running or swimming.<br>
                                    Regualar weekly contact jam.<br>",
                    ],
                    [
                        'title' => 'What is the movement for me?',
                        'text' => "My path to self-development is rooted in body awareness, I deeply trust that working on our ability to be attentive to our inner sensitivity and improving our interoception enable us to connect with ourselves, to ground, to understand our needs, and through this clarity, we can work to express them healthily.<br><br>
                                    I see <b>Contact Improvisation</b> as a way to re-awake and fully enjoy our sensations, playfulness and agility working on trust, explore curiosity about movement principles out of daily movement patterns. Rolling on the ground as we were children and even doing much more fun stuff.
                                    For me, CI is a kind of mindfulness practice that is also oriented to the relation with the other dance partners and the environment we are dancing in.
                                    The constant practice of this dance form affects in this way also my daily life out of the dance floor.<br>
                                    <b>Ilan Lev method</b> work also in this direction, softening the nervous system and muscle tone, releasing past traumas, re-enabling the body-mind to perceive and sense through his full potential.<br>",
                    ],
                    [
                        'title' => 'Studies',
                        'text' => "
                        <ul>
                        <li class='pb-2'>
                            <h4 class='text-xl font-bold mb-1'>Dance Studies</h4>
                            Workshops about CI <br>
                            Marco Zontini ('10, '11), Roberto Lun (’10, ’11, ’12, ‘13), Nita Little ('13, '14, '15, '16, '21), Javier Curia ('10), Vera de Propris ('13), Bernd Knappe ('12, '12, '13), Thomas Kampe ('12, ’13), Daniel Lepkoff (’14), Itay Iatuv (’14, '15), Yaniv Mintzer (‘16, '19), Joerg Hassman (’16), Adrian Russi (’16), Kirstie Simson (’11, '21), Ester Momblance (’10), Katri Luukkonen(’11), Scott Wells(’11), Alicia Grayson(’11), Ray Chung ('12, '13), Nancy Stark Smith (’14), Martin Keogh (’15, ’16), Benno Voorham (’13), Ezster Gal (’14), Patricia Kuypers (’15), Alyssa Lynes (’14), Eckard Muller (’13), Frey Faust (’14), Angelica Dony (’16, ’17), Leonardo Lambruschini (’16), Jess Curtis(’17), Simone Magnani (’14), Anatolliy Layaskallo ('11), Tim O’Donnell (’10), Riccardo Meneghini (’15), Claus Springborg (’14), Nuria Urcelay Martinez ('18), Asaf Bachrach ('19), Romain Bigé ('19), Leilani Weiss ('20), Ramon Roig ('20), Charley Morrissey ('20)<br>
                            Other dance workshops <br>
                            Yumiko, Claude coldy
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

        <h2 class="mt-6 sm:mt-14 mb-4 text-xl text-primary-600 font-extrabold tracking-tight sm:text-2xl">Web development</h2>

        <p class="mb-3">
            I work at <a href="https://www.agiledrop.com/" class="textLink" target="_blank">Agiledrop</a> as a PHP backend developer with Laravel and Drupal.<br>
        </p>

        @include('partials.contents.accordion',[
                'accordionNumber' => '1',
                'elements' => [
                    [
                        'title' => 'My Dev stack',
                        'text' => "I'm a <b>Drupal Backend and Laravel TALL stack web developer</b>, with more than ten years of experience.<br><br>
                        Currently, I am exploring Drupal 7-8, Laravel 8, Laravel Livewire, Tailwind CSS, PhpUnit.<br>
                                    I'm an active member of <a href='https://stackoverflow.com/users/10075394/davide-casiraghi' class='textLink'>Stackoverflow</a>.<br><br>

                        <b>Education:</b> Bachelor of Science (Informatics).<br><br>

                        <b>Degree:</b>
                        2006 (BSc) in Computer Science at <a href='https://www.www.unimib.it' class='textLink' target='_blank'>Università Degli Studi di Milano Bicocca</a>, Milano Italia.<br><br>

                        <b>Certification:</b> 2021 Laravel Certification at <a class='textLink' target='_blank' href='https://exam.laravelcert.com/is/davide-casiraghi/certified-since/2021-11-05'>Laravelcert.com</a>.<br><br>
                        ",
                    ],
                ]
            ])



    </div>
@endsection


