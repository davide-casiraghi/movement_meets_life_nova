@extends('layouts.app')

@section('title')@lang('static_pages.footer.book_a_treatment')@endsection

@section('content')

    @include('partials.messages')

        <!-- Calendly inline widget begin -->
        <div class="calendly-inline-widget" style="position:relative; min-width:320px; height:750px;" data-auto-load="false">
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
            <script>
                Calendly.initInlineWidget({
                    url: 'https://calendly.com/davide-casiraghi/90min'
                });
            </script>
        </div>
        <!-- Calendly inline widget end -->

@endsection