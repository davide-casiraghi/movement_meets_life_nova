@php ($barsBackground = '#B5A575')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@hasSection('title')@yield('title') - @endif{{ __('general.website_name') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="{{$barsBackground}}"/> {{-- Theming the browser's address bar to match your brand's colors provides a more immersive user experience.--}}
    <meta name="description" content="@hasSection('description')@yield('description')@else{{ __('general.website_description') }}@endif">

    {{-- Facebook tags  --}}
    @yield('fb-tags')

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ url('favicon.png') }}">

    {{-- CSS e JS --}}
    @vite(['resources/sass/custom.scss', 'resources/css/app.css', 'resources/js/app.js'])

    @yield('css')

    {{-- JS that need to stay in the head --}}
    @yield('javascript-head')

    @livewireStyles

    @include('analytics')

    {{-- SEO Structured Data  --}}
    @hasSection('structured-data')
        @yield('structured-data')
    @endif

    {{-- Blade UI Kit styles --}}
    {{-- End Blade UI Kit styles --}}
</head>

<body class="bg-gray-100 {{--font-body--}}">
    {{--@livewire('navigation-dropdown')--}}

    @include('navigation')

    @hasSection('jumbotron')
        <div class="relative mx-auto">
            @yield('jumbotron')
        </div>
    @endif

    <div class="content relative mx-auto container max-w-7xl">
        @yield('content')
    </div>

    @include('footer')


    @stack('scripts')
    {{-- Load Livewire scripts before Alpine --}}
    @livewireScripts

    @stack('scripts')
    @yield('javascript')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $(function () {
                @yield('javascript-document-ready')
            });
        });
    </script>

    @stack('modals')

    {{--  Blade UI Kit scripts --}}
    {{--  End Blade UI Kit scripts --}}
</body>

</html>
