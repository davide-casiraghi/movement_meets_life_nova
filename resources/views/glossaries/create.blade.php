@extends('layouts.backend')

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('glossaries.store') }}" enctype="multipart/form-data" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Edit glossary term</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the post data
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

                {{-- Translations tabs - Default Contents --}}
                <div class="translation en" x-show.transition.in="translationActive === '{{Config::get('app.fallback_locale')}}'">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('views.term'),
                                    'name' => 'term',
                                    'placeholder' => 'Glossary term',
                                    'value' => old('term'),
                                    'required' => true,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                    'label' => __('views.definition'),
                                    'name' => 'definition',
                                    'placeholder' => '',
                                    'value' => old('definition'),
                                    'required' => false,
                                    'disabled' => false,
                                    'style' => 'plain',
                                    'extraDescription' => 'Anything to show jumbo style before the content',
                                ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('views.body'),
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
                                      //'value' => $glossary->introimage,
                                      'required' => false,
                                      'collection' => 'introimage',
                                      'entity' => null,
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
                                            'label' => __('views.term'),
                                            'name' => 'term_'.$countryCode,
                                            'placeholder' => 'Glossary term',
                                            'value' => old('term_'.$countryCode),
                                            'required' => true,
                                            'disabled' => false,
                                    ])
                                </div>

                                <div class="col-span-6">
                                    @include('partials.forms.textarea', [
                                           'label' => __('views.definition'),
                                           'name' => 'definition_'.$countryCode,
                                           'placeholder' => '',
                                           'value' => old('definition_'.$countryCode), //, $post->body
                                           'required' => false,
                                           'disabled' => false,
                                           'style' => 'plain',
                                           'extraDescription' => 'Anything to show jumbo style after the content',
                                       ])
                                </div>

                                <div class="col-span-6">
                                    @include('partials.forms.textarea', [
                                           'label' => __('views.body'),
                                           'name' => 'body_'.$countryCode,
                                           'placeholder' => '',
                                           'value' => old('body_'.$countryCode), //, $post->body
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
        </div>

        <div class="grid grid-cols-6 gap-6">

            <div class="col-span-6">
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
