<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSS --}}
    @vite(['resources/sass/custom.scss', 'resources/css/app.css'])
</head>

<body class="bg-gray-200">

    <div class="content relative mx-auto container max-w-7xl">

        <div class="flex items-center justify-center h-screen">
            <div class="container">
                <div class="bg-white rounded-lg shadow-lg p-5 md:p-20 mx-2">
                    <div class="text-center">
                        <h2 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
                            <span class="text-primary-600">Movement meets life</span>
                        </h2>
                        <h3 class='text-xl md:text-3xl mt-10'>Coming Soon</h3>
                        <div class="text-gray-500">
                            <p class="text-lg md:text-xl mt-10">
                                Movement meets life is currently down for a scheduled maintenance.
                            </p>
                            <p class="text-base md:text-xl">
                                We expect to be back in a couple of hours.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
