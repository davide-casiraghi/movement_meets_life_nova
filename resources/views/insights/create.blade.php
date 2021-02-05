@extends('layouts.backend')

@section('title')
    @lang('views.create_new_insight')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('insights.store') }}" enctype="multipart/form-data" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        @csrf

        {{-- Insight contents --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Insight contents</h3>
                    {{-- Translations tabs - Buttons --}}
                    <div class="mt-4">
                        @include('partials.forms.languageTabs',[
                            'countriesAvailableForTranslations' => $countriesAvailableForTranslations
                        ])
                    </div>

                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">

                    {{-- Translations tabs - Default Contents --}}
                    <div class="translation en" x-show.transition.in="translationActive === '{{Config::get('app.fallback_locale')}}'">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                @include('partials.forms.input', [
                                        'label' => __('views.title'),
                                        'name' => 'title',
                                        'placeholder' => 'Insight title',
                                        'value' => old('title'),
                                        'required' => true,
                                        'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6">
                                @include('partials.forms.textarea', [
                                       'label' => __('views.text'),
                                       'name' => 'body',
                                       'placeholder' => '',
                                       'value' => old('body'),
                                       'required' => false,
                                       'disabled' => false,
                                       'style' => 'tinymce',
                                       'extraDescription' => 'Anything to show jumbo style after the content',
                                   ])
                            </div>

                            <div class="col-span-6">
                                @include('partials.forms.uploadImage', [
                                          'label' => __('views.intro_image'),
                                          'name' => 'introimage',
                                          'value' => '',
                                          'required' => false,
                                          'collection' => 'introimage',
                                      ])
                            </div>

                            <div class="col-span-6">
                                @include('partials.forms.select_multiple', [
                                    'label' => __('views.tags'),
                                    'name' => 'tag_ids',
                                    'placeholder' => __('event.select_teachers'),
                                    'records' => $tags,
                                    'value_attribute_name' => 'tag',
                                    'required' => TRUE,
                                    'extraClasses' => '',
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
                                                'label' => __('views.title'),
                                                'name' => 'title_'.$countryCode,
                                                'placeholder' => 'Insight title',
                                                'value' => old('title_'.$countryCode),
                                                'required' => true,
                                                'disabled' => false,
                                        ])
                                    </div>

                                    <div class="col-span-6">
                                        @include('partials.forms.textarea', [
                                               'label' => __('views.text'),
                                               'name' => 'body_'.$countryCode,
                                               'placeholder' => '',
                                               'value' => old('body_'.$countryCode),
                                               'required' => false,
                                               'disabled' => false,
                                               'style' => 'tinymce',
                                               'extraDescription' => 'Anything to show jumbo style after the content',
                                           ])
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <a href="{{ route('insights.index') }}">
                <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
            </a>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save
            </button>
        </div>
    </form>
@endsection
