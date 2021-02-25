@extends('layouts.app')

@section('content')

    @include('partials.messages')

    <div class="flex justify-center">
        <form action="{{route('testimonials.store')}}" method="POST" class="max-w-3xl" enctype="multipart/form-data">
            @csrf
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-4">

                <div class="">
                    <h1>
                        Become a Testimonial
                    </h1>
                    <div class="text-lg text-gray-500">
                        Did you enjoy receiving a bodywork and you would love to leave a feedback that I can publish on my website?
                    </div>
                    <div class="text-lg text-gray-500">
                        Since it's a quite unique experience to explain, this will support me to allow people know does it feel to receive an ILM treatment.
                    </div>

                    <p class="text-gray-400 mb-8"></p>
                </div>

                {{-- Your experience --}}
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Your experience</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            This information will be displayed publicly so be careful what you share.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <label for="about" class="block text-sm leading-5 font-medium text-gray-700">
                            Your feedback
                        </label>
                        <div class="rounded-md shadow-sm">
                            <textarea name="feedback" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="A brief description of your experience.">{{ old('feedback') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            This information will be displayed publicly so be careful what you share.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium leading-5 text-gray-700">First name</label>
                                <input name="name" value="{{ old('name') }}" id="first_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="surname" class="block text-sm font-medium leading-5 text-gray-700">Last name</label>
                                <input name="surname" value="{{ old('surname') }}" id="last_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="profession" class="block text-sm font-medium leading-5 text-gray-700">Your profession</label>
                                <input name="profession" value="{{ old('profession') }}" id="profession" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.select', [
                                'label' => 'Your country',
                                'name' => 'country_id',
                                'placeholder' => 'Select one',
                                'records' => $countries,
                                'selected' => old('country_id'),
                                'required' => true,
                                'extraClasses' => 'select2',
                            ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm leading-5 font-medium text-gray-700">
                                    Photo
                                </label>
                                <div class="mt-2 flex items-center">
                                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                      <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                      </svg>
                                    </span>
                                    <span class="ml-5 rounded-md shadow-sm">
                                      {{--<button type="button" class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                        Change
                                      </button>--}}
                                        <label class="py-2 px-3 border border-gray-300 rounded-md text-xs leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                            {{--<svg class="w-5 h-5 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg>--}}
                                            <span class="mt-2 text-base leading-normal">Select a file</span>
                                            <input type='file' name="photo" class="hidden" />
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notifications --}}
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mb-4">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Notifications</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Decide which communications you'd like to receive and how.
                        </p>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <fieldset>
                            <legend class="text-base leading-6 font-medium text-gray-900">Please confirm below to allow to me to publish</legend>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input name="personal_data_agreement" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" @if(old('personal_data_agreement')) checked @endif>
                                        </div>
                                        <div class="ml-3 text-sm leading-5">
                                            <label for="candidates" class="font-medium text-gray-700">Personal data agreement</label>
                                            <p class="text-gray-500">I agree to publish my name, surname and profession and photo.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input name="publish_agreement" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" @if(old('publish_agreement')) checked @endif>
                                    </div>
                                    <div class="ml-3 text-sm leading-5">
                                        <label for="comments" class="font-medium text-gray-700">Feedback agreement</label>
                                        <p class="text-gray-500">I agree to publish my feedback on the testimonial section of this website.</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="mt-8 border-t border-gray-200 pt-5">
                            <div class="flex justify-end">
                                <span class="inline-flex rounded-md shadow-sm">
                                    <a href="{{ route('testimonials.index') }}">
                                        <button type="button" class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                            Cancel
                                        </button>
                                    </a>
                                </span>
                                <span class="ml-3 inline-flex rounded-md shadow-sm">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                        Save
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
