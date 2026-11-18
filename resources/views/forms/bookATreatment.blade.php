@extends('layouts.app')

@section('title')@lang('static_pages.footer.book_a_treatment')@endsection

@section('content')

    @include('partials.messages')

        <div class="text-center mt-5 px-4 md:px-0">
            <h2 class="text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
                @lang('static_pages.book_a_treatment.title')
            </h2>
            <p class="mt-3 max-w-2xl mx-auto text-xl leading-7 text-gray-500 sm:mt-4">
                @lang('static_pages.book_a_treatment.call_to_action_long')
            </p>
        </div>

        <!-- Calendly inline widget begin -->
        <div class="calendly-inline-widget mt-10 sm:mt-0" style="position:relative; min-width:320px; height:850px;" data-auto-load="false">
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
            <script>
                Calendly.initInlineWidget({
                    url: 'https://calendly.com/davide-casiraghi/60min'
                });
            </script>
        </div>
        <!-- Calendly inline widget end -->

@endsection
