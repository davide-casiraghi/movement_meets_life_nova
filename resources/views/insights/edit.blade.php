@extends('layouts.backend')

@section('title')
    @lang('views.edit_insight')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('insights.update',$insight->id) }}" enctype="multipart/form-data" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        @csrf
        @method('PUT')

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
                                        'value' => old('title', $insight->title),
                                        'required' => true,
                                        'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6">
                                @include('partials.forms.textarea', [
                                       'label' => __('views.text'),
                                       'name' => 'body',
                                       'placeholder' => '',
                                       'value' => old('body', $insight->body),
                                       'required' => false,
                                       'disabled' => false,
                                       'style' => 'tinymce',
                                       'extraDescription' => 'Anything to show jumbo style after the content',
                                   ])
                            </div>

                            {{-- Upload Image --}}
                            <div class="col-span-6">
                                @include('partials.forms.uploadImage', [
                                          'label' => __('views.intro_image'),
                                          'name' => 'introimage',
                                          'required' => false,
                                          'collection' => 'introimage',
                                          'entity' => $insight,
                                      ])
                            </div>

                            {{-- Tags --}}
                            <div class="col-span-6">
                                @include('partials.forms.select_multiple', [
                                    'label' => __('views.tags'),
                                    'name' => 'tag_ids',
                                    'placeholder' => __('views.select_tags'),
                                    'records' => $tags,
                                    'value_attribute_name' => 'tag',
                                    'selected' => $insight->tags->modelKeys(),
                                    'required' => TRUE,
                                    'extraClasses' => '',
                                ])
                            </div>

                            {{-- Published --}}
                            <div class="col-span-6">
                                @php
                                    $checked = ($insight->isPublished()) ? "checked" : "";
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
                                                'label' => __('views.title'),
                                                'name' => 'title_'.$countryCode,
                                                'placeholder' => 'Insight title',
                                                'value' => old('title_'.$countryCode, $insight->getTranslation('title', $countryCode)),
                                                'required' => true,
                                                'disabled' => false,
                                        ])
                                    </div>

                                    <div class="col-span-6">
                                        @include('partials.forms.textarea', [
                                               'label' => __('views.text'),
                                               'name' => 'body_'.$countryCode,
                                               'placeholder' => '',
                                               'value' => old('body_'.$countryCode, $insight->getTranslation('body', $countryCode)),
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

        {{-- Facebook --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Facebook</h3>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('views.post'),
                                   'name' => 'facebook_body',
                                   'placeholder' => '',
                                   'value' => old('facebook_body', $insight->facebook_body),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'plain',
                                   'extraDescription' => '',
                               ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                   'label' => __('views.post_url'),
                                   'name' => 'facebook_url',
                                   'placeholder' => '',
                                   'value' => old('facebook_url', $insight->facebook_url),
                                   'required' => false,
                                   'disabled' => false,
                               ])
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Twitter --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Twitter</h3>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('views.post'),
                                   'name' => 'twitter_body',
                                   'placeholder' => '',
                                   'value' => old('twitter_body', $insight->twitter_body),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'plain',
                                   'extraDescription' => '',
                               ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                   'label' => __('views.post_url'),
                                   'name' => 'twitter_url',
                                   'placeholder' => '',
                                   'value' => old('twitter_url', $insight->twitter_url),
                                   'required' => false,
                                   'disabled' => false,
                               ])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instagram --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Instagram</h3>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('views.post'),
                                   'name' => 'instagram_body',
                                   'placeholder' => '',
                                   'value' => old('instagram_body', $insight->instagram_body),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'plain',
                                   'extraDescription' => '',
                               ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                   'label' => __('views.post_url'),
                                   'name' => 'instagram_url',
                                   'placeholder' => '',
                                   'value' => old('instagram_url', $insight->instagram_url),
                                   'required' => false,
                                   'disabled' => false,
                               ])
                        </div>

                    </div>
                </div>
            </div>
        </div>



        {{-- Utility --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Utility</h3>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            @include('partials.forms.input', [
                                    'label' => __('views.link_to_this_insight'),
                                    'name' => 'insight_link',
                                    'placeholder' => '',
                                    'value' => env('APP_URL').'/insight/'.$insight->slug,
                                    'required' => false,
                                    'disabled' => true,
                                ])
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            @include('partials.forms.input', [
                                    'label' => __('views.insight_id'),
                                    'name' => 'insight_id',
                                    'placeholder' => '',
                                    'value' => $insight->id,
                                    'required' => false,
                                    'disabled' => true,
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
                    'url' => route('insights.show',$insight->id),
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
                    <a href="{{ route('insights.index') }}">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection
