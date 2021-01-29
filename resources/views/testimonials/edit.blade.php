@extends('layouts.backend')

@section('title')
    @lang('views.edit_testimonial')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('testimonials.update',$testimonial->id) }}" enctype="multipart/form-data" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              {{--<h3 class="text-lg font-medium leading-6 text-gray-900">Edit testimonial</h3>--}}
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the testimonial data
                </p>
              --}}

                {{-- Translations tabs - Buttons --}}
                <div class="mt-4">
                    @include('partials.forms.languageTabs',[
                        'countriesAvailableForTranslations' => $countriesAvailableForTranslations
                    ])
                </div>

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                @csrf
                @method('PUT')

                {{-- Translations tabs - Default Contents --}}
                <div class="translation en" x-show.transition.in="translationActive === '{{Config::get('app.fallback_locale')}}'">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('general.name'),
                                    'name' => 'name',
                                    'placeholder' => '',
                                    'value' => old('name', $testimonial->name),
                                    'required' => true,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('general.surname'),
                                    'name' => 'surname',
                                    'placeholder' => '',
                                    'value' => old('surname', $testimonial->surname),
                                    'required' => false,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('general.country'),
                                'name' => 'country_id',
                                'placeholder' => '',
                                'records' => $countries,
                                'selected' => $testimonial->country_id,
                                'required' => true,
                                'extraClasses' => 'select2',
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('views.profession'),
                                   'name' => 'profession',
                                   'placeholder' => '',
                                   'value' => old('profession', $testimonial->profession),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'plain',
                                   'extraDescription' => '',
                               ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('views.feedback'),
                                   'name' => 'feedback',
                                   'placeholder' => '',
                                   'value' => old('feedback', $testimonial->feedback),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'plain',
                                   'extraDescription' => '',
                               ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.uploadImage', [
                                      'label' => __('views.photo'),
                                      'name' => 'photo',
                                      'required' => false,
                                      'collection' => 'photo',
                                      'entity' => $testimonial,
                                  ])
                        </div>

                        <div class="col-span-6">
                            @php
                                $checked = old('personal_data_agreement') ? "checked" : "";
                            @endphp
                            @include('partials.forms.checkbox', [
                                'label' => __('views.personal_data_agreement'),
                                'id'  => 'personal_data_agreement',
                                'name' => 'personal_data_agreement',
                                'size' => 'small',
                                'required' => false,
                                'checked' => $checked,
                            ])
                        </div>

                        <div class="col-span-6">
                            @php
                                $checked = old('publish_agreement') ? "checked" : "";
                            @endphp
                            @include('partials.forms.checkbox', [
                                'label' => __('views.publish_agreement'),
                                'id'  => 'publish_agreement',
                                'name' => 'publish_agreement',
                                'size' => 'small',
                                'required' => false,
                                'checked' => $checked,
                            ])
                        </div>

                        <div class="col-span-6">
                            @php
                                $checked = ($testimonial->isPublished()) ? "checked" : "";
                            @endphp
                            @include('partials.forms.checkbox', [
                                'label' => __('views.published'),
                                'id'  => 'status',
                                'name' => 'status',
                                'size' => 'small',
                                'required' => false,
                                'checked' => $checked,
                            ])
                        </div>
                    </div>
                </div>

                {{-- Translations tabs - Contents translated other languages --}}
                @foreach ($countriesAvailableForTranslations as $countryCode => $countryAvTrans)
                    @if($countryCode != Config::get('app.fallback_locale'))
                        <div class="translation {{$countryCode}}" x-show.transition.in="translationActive === '{{$countryCode}}'">
                            <div class="grid grid-cols-6 gap-6">

                                <div class="col-span-6">
                                    @include('partials.forms.input', [
                                            'label' => __('views.profession'),
                                            'name' => 'profession_'.$countryCode,
                                            'placeholder' => 'profession',
                                            'value' => old('profession_'.$countryCode, $testimonial->getTranslation('profession', $countryCode)),
                                            'required' => true,
                                            'disabled' => false,
                                    ])
                                </div>

                                <div class="col-span-6">
                                    @include('partials.forms.textarea', [
                                           'label' => __('views.feedback'),
                                           'name' => 'feedback_'.$countryCode,
                                           'placeholder' => '',
                                           'value' => old('feedback_'.$countryCode, $testimonial->getTranslation('feedback', $countryCode)),
                                           'required' => false,
                                           'disabled' => false,
                                           'style' => 'plain',
                                           'extraDescription' => '',
                                       ])
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
          </div>
        </div>

        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-3">
                @include('partials.forms.button',[
                    'title' => 'View',
                    'url' => route('testimonials.show',$testimonial->id),
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
                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection
