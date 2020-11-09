@extends('layouts.app')

@section('content')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-6">

        <h2 class="text-gray-900 text-3xl mb-4">About me</h2>

        <p class="mb-3">
            <b>Davide Casiraghi</b> (BSc) in Computer Science, Senior IT Web Developer, Contact Improvisation dance teacher, Ilan Lev method practitioner, based in Slovenia.<br>
            In Slovenia, he is co-creator with Nayeli Spela Peterlin of <b>Moave - Psychology in movement - www.moave.si.</b><br>
            He is currently giving Contact Improvisation regular classes and Ilan Lev method bodyworks in Ljubljana.<br>
        </p>
        <p class="mb-3">
            Member of the <b>Round Robin Project</b> that has the aim to create tools for global networking of the worldwide Contact Improvisation community. He is web designer, developer and technical manager of the <b>Contact Improvisation Global Calendar (CIGG)</b> - www.ciglobalcalendar.net <br>
            Previously from 2010 to 2018 webmaster of the <b>Contact Improvisation Italian website</b> - www.contactimprov.it (now closed)
        </p>
        <p class="mb-3">
            Passionate free-diver and monofin swimmer he is researching about deep water CI dances and he is co-organizer of <b>Deep Water Dance Festival 2018</b> - deepwaterdancefestival.altervista.org
        </p>




        <div class="accordion flex flex-col items-center justify-center mt-4">
            <!--  Panel 1  -->
            <div class="w-full">
                <input type="checkbox" name="panel" id="panel-1" class="hidden">
                <label for="panel-1" class="relative block bg-black text-white p-4 shadow border-b border-grey">
                    Where does my path of movement awareness start?
                </label>
                <div class="accordion__content overflow-hidden bg-grey-lighter">
                    <p class="accordion__body p-4" id="panel1">
                        I'm a twin brother, when somebody asks me when did I start to practice Contact Improvisation, I could answer, from day 0 of my life.<br>
                        For the most of people life start as a solo, in a space that our mother hold for us.<br>
                        There I was floating in a warm liquid and I was relating with another person, my brother Alessio.<br>
                        For 9 months we shared the same space, his presence there was strongly affecting my experience of life and mine for him too.<br><br>

                        Years later, at the age of 27, passing trough a moment of life crisis, I attended a Contact Improvisation workshop and I discovered that I was living mostly dissociate by my body and my emotions.<br>
                        And from that moment i"m in love with self awareness practices.<br>
                        I live them as a way to care my personal  integrity.<br>
                        When I feel connected with myself and I listed yo my body,  I'm more productive, more able to listen to others, more emphatic, I find more pleasure in what I'm doing, I respect my body, I don't get sick.<br>
                    </p>
                </div>
            </div>

            <!--  Panel 2  -->
            <div class="w-full">
                <input type="checkbox" name="panel" id="panel-2" class="hidden">
                <label for="panel-2" class="relative block bg-black text-white p-4 shadow border-b border-grey">
                    What are my practices to cultivate my self connection?
                </label>
                <div class="accordion__content overflow-hidden bg-grey-lighter">
                    <p class="accordion__body p-4" id="panel2">
                        At the moment I have a daily routine of yoga or ILM movement class. <br>
                        Almost daily rollerblading.<br>
                        Sometimes running or swimming.<br>
                        Regualar weekly contact jam.<br>
                    </p>
                </div>
            </div>

            <!--  Panel 3  -->
            <div class="w-full">
                <input type="checkbox" name="panel" id="panel-3" class="hidden">
                <label for="panel-3" class="relative block bg-black text-white p-4 shadow border-b border-grey">
                    What is the movement for me?
                </label>
                <div class="accordion__content overflow-hidden bg-grey-lighter">
                    <p class="accordion__body p-4" id="panel3">
                        My path to self-development is rooted in body awareness, I deeply trust that working on our ability to be attentive to our inner sensitivity and improving our interoception enable us to connect with ourselves, to ground, to understand our needs, and through this clarity, we can work to express them healthily.<br>
                        I see <b>Contact Improvisation</b> as a way to re-awake and fully enjoy our sensations, playfulness and agility working on trust, explore curiosity about movement principles out of daily movement patterns. Rolling on the ground as we were children and even doing much more fun stuff.
                        For me, CI is a kind of mindfulness practice that is also oriented to the relation with the other dance partners and the environment we are dancing in.
                        The constant practice of this dance form affects in this way also my daily life out of the dance floor.<br>
                        <b>Ilan Lev method</b> work also in this direction, softening the nervous system and muscle tone, releasing past traumas, re-enabling the body-mind to perceive and sense through his full potential.<br>
                    </p>
                </div>
            </div>

            <!--  Panel 4  -->
            <div class="w-full">
                <input type="checkbox" name="panel" id="panel-4" class="hidden">
                <label for="panel-4" class="relative block bg-black text-white p-4 shadow border-b border-grey">
                    Degree
                </label>
                <div class="accordion__content overflow-hidden bg-grey-lighter">
                    <p class="accordion__body p-4" id="panel4">
                    <ul>
                        <li>
                            2006 (BSc) in Computer Science - Università Degli Studi di Milano Bicocca, Milano Italia (www.unimib.it)
                        </li>
                        <li>
                            2016 - RYT200 Yoga Alliance Certification @ Hari Om - Cascina Bellaria (www.hari-om.it)
                        </li>
                        <li>
                            2015 - 2016 Freediving certification FIPSAS PAp1 - Monofin Freediving certification FIPSAS PApm (www.fipsas.it)
                        </li>
                        <li>
                            2017-2019 - Ilan Lev Method bodywork certification
                        </li>
                        <li>
                            2019 - Ilan Lev Method movement classes facilitator certification (www.ilanlev.org)
                        </li>
                    </ul>
                    </p>
                </div>
            </div>


        </div>





    </div>
@endsection


