@extends('layouts.app')

@section('content')

    @include('partials.messages')

    <div class="flex justify-center">
        <form action="{{route('testimonials.store')}}" method="POST" class="max-w-3xl">
            @csrf
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-4">

                <div class="">
                    <h1>
                        Contact me
                    </h1>
                    <div class="text-lg text-gray-500">
                        Please, feel free to contact me.
                    </div>
                    <div class="text-lg text-gray-500">
                        I'm glad to get in touch, answer questions, get inspired and to receive feedbacks about my classes and treatments.
                    </div>


                    <p class="text-gray-400 mb-8"></p>
                </div>

                {{-- Your experience --}}
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">Your message</div>
                        {{--<p class="mt-1 text-sm leading-5 text-gray-500">
                            This information will be displayed publicly so be careful what you share.
                        </p>--}}
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        {{-- <label for="about" class="block text-sm leading-5 font-medium text-gray-700">
                             Your feedback
                         </label>--}}
                        <div class="">
                            <textarea name="feedback" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary-300" placeholder="">{{ old('feedback') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">Personal Information</div>
                        {{--<p class="mt-1 text-sm leading-5 text-gray-500">
                            This information will be displayed publicly so be careful what you share.
                        </p>--}}
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium leading-5 text-gray-700">First name</label>
                                <input name="name" value="{{ old('name') }}" id="first_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="surname" class="block text-sm font-medium leading-5 text-gray-700">Last name</label>
                                <input name="surname" value="{{ old('surname') }}" id="last_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Your email</label>
                                <input name="email" value="{{ old('email') }}" id="email" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Send button --}}
            <div class="mt-6 px-4 py-5 sm:p-6 mb-4">
                <div class="flex justify-end">
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                            Send
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </div>
@endsection
