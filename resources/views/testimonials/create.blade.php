@extends('layouts.app')

@section('title')@lang('static_pages.footer.become_a_testimonial')@endsection

@section('content')

    @include('partials.messages')

    <div class="flex justify-center px-4 md:px-0">
        <form action="{{route('testimonials.store')}}" method="POST" class="max-w-3xl" enctype="multipart/form-data">
            @csrf
            @honeypot
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-4">

                <div class="">
                    <h1>
                        {{__('forms.become_a_testimonial.become_a_testimonial')}}
                    </h1>
                    <div class="text-lg text-gray-500">
                        {{__('forms.become_a_testimonial.did_you_enjoy')}}
                    </div>
                    <div class="text-lg text-gray-500">
                        {{__('forms.become_a_testimonial.unique_experience')}}
                    </div>

                    <p class="text-gray-400 mb-8"></p>
                </div>

                {{-- Your experience --}}
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">{{__('forms.become_a_testimonial.fields.your_experience')}}</div>
                        {{--<p class="mt-1 text-sm leading-5 text-gray-500">
                            Lorem ipsum description
                        </p>--}}
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="">
                            @include('partials.forms.textarea', [
                                'label' => '',
                                'name' => 'feedback',
                                'placeholder' => __('forms.become_a_testimonial.brief_description'),
                                'value' => old('feedback'),
                                'required' => true,
                                'disabled' => false,
                                'style' => 'plain',
                                'extraDescription' => '',
                            ])

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
                                @include('partials.forms.input', [
                                    'label' => __('forms.become_a_testimonial.fields.your_name'),
                                    'name' => 'name',
                                    'placeholder' => '',
                                    'value' => old('name'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.become_a_testimonial.fields.your_surname'),
                                    'name' => 'surname',
                                    'placeholder' => '',
                                    'value' => old('surname'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.become_a_testimonial.fields.your_profession'),
                                    'name' => 'profession',
                                    'placeholder' => '',
                                    'value' => old('profession'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.select', [
                                'label' => __('forms.become_a_testimonial.fields.your_country'),
                                'name' => 'country_id',
                                'placeholder' => 'Select one',
                                'records' => $countries,
                                'selected' => old('country_id'),
                                'required' => true,
                                'extraClasses' => 'select2',
                            ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.become_a_testimonial.fields.your_email'),
                                    'name' => 'email',
                                    'placeholder' => '',
                                    'value' => old('email'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm leading-5 font-medium text-gray-700">
                                    {{__('forms.become_a_testimonial.fields.photo')}}
                                </label>
                                <div class="mt-2 flex items-center">
                                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                      <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                      </svg>
                                    </span>
                                    <span class="ml-5 rounded-md shadow-sm">
                                      {{--<button type="button" class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-primary-300 focus:ring-primary active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                        Change
                                      </button>--}}
                                        <label class="py-2 px-3 border border-gray-300 rounded-md text-xs leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-primary-300 focus:ring-primary active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                            {{--<svg class="w-5 h-5 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg>--}}
                                            <span class="mt-2 text-base leading-normal">{{__('forms.become_a_testimonial.select_a_file')}}</span>
                                            <input type='file' name="photo" class="hidden" />
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Publish agreement --}}
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mb-4">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">{{__('forms.become_a_testimonial.publish_agreement')}}</div>
                        {{--<p class="mt-1 text-sm leading-5 text-gray-500">
                            Lorem ipsum description
                        </p>--}}
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <fieldset>
                            <legend class="text-base leading-6 font-medium text-gray-900">{{__('forms.become_a_testimonial.please_confirm')}}</legend>
                            <div class="mt-4">
                                <div class="mb-4">
                                    @include('partials.forms.checkbox', [
                                        'label' => __('forms.become_a_testimonial.personal_data_agreement'),
                                        'description'  => __('forms.become_a_testimonial.i_agree_publish'),
                                        'id'  => 'personal_data_agreement',
                                        'name' => 'personal_data_agreement',
                                        'size' => 'small',
                                        'required' => true,
                                        'checked' => false,
                                    ])
                                </div>
                                <div class="mb-4">
                                    @include('partials.forms.checkbox', [
                                        'label' => __('forms.become_a_testimonial.feedback_agreement'),
                                        'description'  => __('forms.become_a_testimonial.agree_feedback'),
                                        'id'  => 'publish_agreement',
                                        'name' => 'publish_agreement',
                                        'size' => 'small',
                                        'required' => true,
                                        'checked' => false,
                                    ])
                                </div>
                            </div>
                        </fieldset>

                        <div class="mt-8 border-t border-gray-200 pt-5">
                            <div class="flex justify-end">
                                <span class="inline-flex rounded-md shadow-sm">
                                    <a href="{{ url()->previous() }}">
                                        <button type="button" class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-primary-300 focus:ring-primary active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                            {{__('forms.become_a_testimonial.cancel')}}
                                        </button>
                                    </a>
                                </span>
                                <span class="ml-3 inline-flex rounded-md shadow-sm">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:border-primary-700 focus:ring-primary active:bg-primary-700 transition duration-150 ease-in-out">
                                        {{__('forms.become_a_testimonial.save')}}
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
