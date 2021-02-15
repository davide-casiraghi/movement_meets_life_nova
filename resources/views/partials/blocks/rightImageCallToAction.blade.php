{{--
    ButtonLink form field

    PARAMETERS:
        - $title:
        - $body:
        - $button_text:
        - $button_url:
        - $image_url:
        - $image_alignment: left|right
--}}

@switch($image_alignment)
    @case('left')
        @php ($imageAlignmentClass = 'md:flex-row-reverse')
    @break

    @case('right')
        @php ($imageAlignmentClass = 'md:flex-row')
    @break

@endswitch

<section class="text-gray-700 body-font">
    <div class="container flex flex-col items-center mx-auto lg:gap-y-16 md:gap-y-24 lg:gap-x-5 md:gap-x-20 {{$imageAlignmentClass}}">
        <div class="flex flex-col items-center w-full pt-0 mb-16 text-left lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 lg:mr-20 md:items-start md:text-left md:mb-0 lg:text-center">

            {{-- text-3xl font-extrabold tracking-tight text-gray-900 --}}
            <h1 class="mb-8 text-2xl font-bold tracking-tighter text-center text-blue-800 lg:text-left lg:text-2xl title-font">
                {{$title}}
            </h1>
            <p class="mb-8 leading-relaxed text-center text-lg text-gray-500 lg:text-left lg:text-1xl">
                {{$body}}
            </p>
            <div class="flex justify-center">
                <a href={{$button_url}} class="flex items-center px-4 py-2 mt-auto font-semibold text-white transition duration-500 ease-in-out transform rounded-lg shadow-xl bg-gradient-to-r from-blue-700 hover:from-blue-600 to-blue-600 hover:to-blue-700 hover:-translate-y-1 hover:scale-110 focus:shadow-outline focus:outline-none">
                     {{$button_text}}
                </a>
            </div>
        </div>
        <div class="w-5/6 lg:max-w-lg lg:w-full md:w-1/2">
            <img class="object-cover object-center rounded-lg " alt="hero" src="https://dummyimage.com/720x600/F3F4F7/8693ac">
        </div>
    </div>
</section>

