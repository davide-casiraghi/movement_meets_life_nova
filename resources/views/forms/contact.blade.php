@extends('layouts.app')

@section('title')@lang('static_pages.footer.contact_me')@endsection

@section('content')

    @include('partials.messages')

    <div class="flex justify-center px-4 md:px-0">
        <form action="{{route('contact.store')}}" method="POST" class="max-w-3xl">
            @csrf
            @honeypot
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-4">

                <div class="mb-8">
                    <h1>
                        {{__('forms.contact_me.contact_me')}}
                    </h1>
                    <div class="text-lg text-gray-500">
                        {{__('forms.contact_me.feel_free')}}
                    </div>
                    <div class="text-lg text-gray-500">
                        {{__('forms.contact_me.im_glad')}}
                    </div>
                </div>

                {{-- Your experience --}}
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">{{__('forms.contact_me.your_message')}}</div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        @include('partials.forms.textarea', [
                                   'label' => '',
                                   'name' => 'message',
                                   'placeholder' => '',
                                   'value' =>  old('message'),
                                   'required' => true,
                                   'disabled' => false,
                                   'style' => 'plain',
                                   'extraDescription' => '',
                               ])
                    </div>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="mt-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="text-lg text-gray-600 font-extrabold tracking-tight sm:text-xl">{{__('forms.contact_me.personal_information')}}</div>
                        {{--<p class="mt-1 text-sm leading-5 text-gray-500">
                            Lorem ipsum description
                        </p>--}}
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.contact_me.fields.first_name'),
                                    'name' => 'name',
                                    'placeholder' => '',
                                    'value' => old('name'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.contact_me.fields.last_name'),
                                    'name' => 'surname',
                                    'placeholder' => '',
                                    'value' => old('surname'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @include('partials.forms.input', [
                                    'label' => __('forms.contact_me.fields.your_email'),
                                    'name' => 'email',
                                    'placeholder' => '',
                                    'value' => old('email'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Send button --}}
            <div class="mt-6 py-5 mb-4">
                <div class="flex justify-end">
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:border-primary-700 focus:ring-primary active:bg-primary-700 transition duration-150 ease-in-out">
                            {{__('forms.contact_me.send')}}
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </div>
@endsection
