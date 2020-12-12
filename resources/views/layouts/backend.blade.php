@php ($barsBackground = '#B5A575')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="{{$barsBackground}}"/> {{-- Theming the browser's address bar to match your brand's colors provides a more immersive user experience.--}}
    <meta name="description" content="@hasSection('description')@yield('description')@else @lang('homepage-serach.find_information')@endif">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')

    {{-- JS that need to stay in the head--}}
    @yield('javascript-head')

    {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">--}}

    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="h-screen flex overflow-hidden bg-gray-100"
         x-data="{ sidebarOpen: false }"
         @keydown.window.escape="sidebarOpen = false"
    >
      
      @include('partials.dashboard.mobileMenu')
      
      @include('partials.dashboard.desktopMenu')

      <div class="flex flex-col w-0 flex-1 overflow-hidden">

        @include('partials.dashboard.topBar')

        <main class="flex-1 relative overflow-y-auto focus:outline-none" tabindex="0">
          <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
              <h1 class="text-2xl font-semibold text-gray-900">
                  @yield('title')
              </h1>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-4">
              <!-- Replace with your content -->
              @yield('content')
              <!-- /End replace -->
            </div>
          </div>
        </main>
      </div>
    </div>

    {{-- Load Livewire scripts before Alpine --}}
    @livewireScripts

    {{-- JS --}}
    <script src="{{ asset('js/manifest.js') }}" ></script>
    <script src="{{ asset('js/vendor.js') }}" ></script>
    <script src="{{ asset('js/app.js') }} " ></script>

    @yield('javascript')

    <script>
        $(document).ready(function(){
            @yield('javascript-document-ready')
        });
    </script>

    @stack('modals')

</body>
</html>
