@extends('layouts.backend')

@section('title')
    @lang('event.create_new_event')
@endsection

@section('content')

    <form class="space-y-6" method="POST" action="{{ route('events.store') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">

            <div class="md:grid md:grid-cols-3 md:gap-6">

                {{-- Notice --}}
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.notice')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.first_country_event_notice')
                    </p>
                </div>

                {{-- Notice contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">

                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('views.title'),
                                    'name' => 'title',
                                    'placeholder' => '',
                                    'value' => old('title'),
                                    'required' => TRUE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('event.category'),
                                'name' => 'event_category_id',
                                'placeholder' => __('views.select_category'),
                                'records' => $eventCategories,
                                'selected' => old('event_category_id'),
                                'required' => TRUE,
                            ])
                        </div>


                    </div>
                </div>

                {{-- People --}}
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.people')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.select_one_or_more_people')
                    </p>
                </div>

                {{-- People contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('general.teachers'),
                                'name' => 'teacher_id',
                                'placeholder' => __('event.select_teachers'),
                                'records' => $teachers,
                                'selected' => old('teacher_id'),
                                'required' => TRUE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('general.organizers'),
                                'name' => 'organizer_id',
                                'placeholder' => __('event.select_organizers'),
                                'records' => $organizers,
                                'selected' => old('organizer_id'),
                                'required' => TRUE,
                            ])
                        </div>

                    </div>
                </div>

                {{-- Venue --}}
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('general.venue')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.select_venue')
                    </p>
                </div>

                {{-- Venue contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('general.venue'),
                                'name' => 'venue_id',
                                'placeholder' => __('event.select_venue'),
                                'records' => $venues,
                                'selected' => old('venue_id'),
                                'required' => TRUE,
                            ])
                        </div>

                    </div>
                </div>

                {{-- Description --}}
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('general.description')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.please_insert_english_translation')
                    </p>
                </div>

                {{-- Description contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('general.description'),
                                   'name' => 'description',
                                   'placeholder' => '',
                                   'value' => old('description'),
                                   'required' => TRUE,
                                   'disabled' => FALSE,
                                   'style' => 'tinymce',
                                   'extraDescription' => 'Anything to show jumbo style after the content',
                               ])
                        </div>

                    </div>
                </div>


                {{-- Duration --}}
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.start_end_duration')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.please_use_repeat_until')
                    </p>
                </div>

                {{-- Duration contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">

                    {{-- Start date --}}
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-3">
                            {{--@include('partials.forms.inputDatePicker')--}}

                            <div class="col-12 col-md-3 mb-2 mb-lg-0">
                                @include('partials.forms.inputDatePicker',[
                                    'class' => 'datepicker',
                                    'label' => __('event.date_start'),
                                    'placeholder' => __('general.select_date'),
                                    'name' => 'startDate',
                                    'value' => old('startDate'),
                                    'required' => true,
                                ])
                            </div>
                        </div>
                        <div class="col-span-3">
                            @include('partials.forms.inputTimePicker', [
                                      'label' =>  __('event.time_start'),
                                      'name' => 'time_start',
                                      'placeholder' => __('event.select_time'),
                                      'value' => old('time_start'),
                                      'required' => true,
                                ])
                        </div>
                    </div>

                    {{-- End date --}}
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-3">
                            @include('partials.forms.inputDatePicker',[
                                    'class' => 'datepicker',
                                    'label' => __('event.date_end'),
                                    'placeholder' => __('general.select_date'),
                                    'name' => 'endDate',
                                    'value' => old('endDate'),
                                    'required' => true,
                                ])
                        </div>
                        <div class="col-span-3">
                            @include('partials.forms.inputTimePicker', [
                                     'label' =>  __('event.time_end'),
                                     'name' => 'time_end',
                                     'placeholder' => __('event.select_time'),
                                     'value' => old('time_end'),
                                     'required' => true,
                               ])
                        </div>
                    </div>

                    {{-- Repeat type --}}
                    @include('partials.events.repeat-event')

                </div>

                {{-- Links & Contacts --}}
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.contacts_and_links')</h3>
                    <p class="mt-1 text-sm text-gray-500">

                    </p>
                </div>

                {{-- Links & Contacts contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('event.email_for_more_info'),
                                    'name' => 'contact_email',
                                    'placeholder' => '',
                                    'value' => old('contact_email'),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('event.facebook_event'),
                                    'name' => 'facebook_event_link',
                                    'placeholder' => '',
                                    'value' => old('facebook_event_link'),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('event.event_url'),
                                    'name' => 'website_event_link',
                                    'placeholder' => '',
                                    'value' => old('website_event_link'),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>
                    </div>
                </div>


                {{-- Event teaser image --}}
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.event_teaser_image')</h3>
                    <p class="mt-1 text-sm text-gray-500">

                    </p>
                </div>

                {{-- Event teaser image contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.uploadImage', [
                                      'label' => __('event.upload_event_teaser_image'),
                                      'name' => 'introimage',
                                      'required' => FALSE,
                                      'collection' => 'introimage',
                                      //'entity' => $event,
                                  ])
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-6 gap-6">

            <div class="col-span-6">
                <div class="flex justify-end mt-4">
                    <button type="button"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </div>


    </form>




@endsection