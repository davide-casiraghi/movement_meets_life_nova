@extends('layouts.backend')

@section('title')
    @lang('event.edit_event')
@endsection

@section('content')

    <form class="space-y-6" method="POST" action="{{ route('events.update',$event->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                    'title' => __('views.title'),
                                    'name' => 'title',
                                    'placeholder' => '',
                                    'value' => old('title', $event->title),
                                    'required' => TRUE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'title' => __('event.category'),
                                'name' => 'event_category_id',
                                'placeholder' => __('ui.events.select_category'),
                                'records' => $eventCategories,
                                'selected' => $event->event_category_id,
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
                                'title' => __('ui.events.teacher'),
                                'name' => 'teacher_id',
                                'placeholder' => __('ui.events.select_teacher'),
                                'records' => $teachers,
                                'selected' => $event->teacher_id,
                                'required' => TRUE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'title' => __('ui.events.organizer'),
                                'name' => 'organizer_id',
                                'placeholder' => __('ui.events.select_organizer'),
                                'records' => $organizers,
                                'selected' => $event->organizer_id,
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
                                'title' => __('general.venue'),
                                'name' => 'venue_id',
                                'placeholder' => __('ui.events.select_venue'),
                                'records' => $venues,
                                'selected' => $event->venue_id,
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
                                   'title' => __('general.description'),
                                   'name' => 'description',
                                   'placeholder' => '',
                                   'value' => old('description', $event->description),
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
                                    'label' => '',
                                    'placeholder' => 'Created after',
                                    'name' => 'startDate',
                                    'value' => old('startDate', $eventDateTimeParameters['dateStart']),
                                ])
                            </div>
                        </div>
                        <div class="col-span-3">
                            time picker
                        </div>
                    </div>

                    {{-- End date --}}
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-3">
                            @include('partials.forms.inputDatePicker',[
                                    'class' => 'datepicker',
                                    'label' => '',
                                    'placeholder' => 'Created after',
                                    'name' => 'endDate',
                                    'value' => old('endDate', $eventDateTimeParameters['dateEnd']),
                                ])
                        </div>
                        <div class="col-span-3">
                            time picker
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
                                    'title' => __('event.email_for_more_info'),
                                    'name' => 'contact_email',
                                    'placeholder' => '',
                                    'value' => old('contact_email', $event->contact_email),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'title' => __('event.facebook_event'),
                                    'name' => 'facebook_event_link',
                                    'placeholder' => '',
                                    'value' => old('facebook_event_link', $event->facebook_event_link),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'title' => __('event.event_url'),
                                    'name' => 'website_event_link',
                                    'placeholder' => '',
                                    'value' => old('website_event_link', $event->website_event_link),
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
                                      'title' => __('views.upload_profile_picture'),
                                      'name' => 'profile_picture',
                                      'required' => FALSE,
                                      'collection' => 'profile_picture',
                                      'entity' => $event,
                                  ])
                        </div>

                    </div>
                </div>


            </div>
        </div>

        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-3">
                @include('partials.forms.button',[
                    'title' => 'View',
                    'url' => route('events.show',$event->id),
                    'color' => 'indigo',
                    'icon' => '<svg class="flex-shrink-0 mr-1.5 h-5 w-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>',
                    'size' => 1,
                    'extraClasses' => 'mt-4',
                    'kind' => 'secondary',
                    'target' => '_blank',
                ])
            </div>

            <div class="col-span-3">
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
