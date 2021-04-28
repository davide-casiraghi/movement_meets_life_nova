@extends('layouts.app')

@section('title')@lang('static_pages.footer.book_a_treatment')@endsection

@section('content')

    @include('partials.messages')

        <div class="text-center mt-5 px-4 md:px-0">
            <h2 class="text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
                Book a treatment
            </h2>
            <p class="mt-3 max-w-2xl mx-auto text-xl leading-7 text-gray-500 sm:mt-4">
                To book a treatment, please select one of the available time frames. <br>
                If no one fits your schedule, please <a class="textLink" href="contact" >contact me</a>, and we will find a solution.
            </p>
        </div>

        <!-- Calendly inline widget begin -->
        <div class="calendly-inline-widget mt-10 sm:mt-0" style="position:relative; min-width:320px; height:850px;" data-auto-load="false">
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
            <script>
                Calendly.initInlineWidget({
                    url: 'https://calendly.com/davide-casiraghi/90min'
                });
            </script>
        </div>
        <!-- Calendly inline widget end -->

@endsection