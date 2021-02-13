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
                <div class="md:col-span-1 flex">
                    <svg class="h-6 w-6 text-gray-800 inline mr-2" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 inline">Facebook</h3>
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

                        <div class="col-span-6 sm:col-span-3">
                            @include('partials.forms.inputDatePicker',[
                                    'class' => 'datepicker all',
                                    'label' => __('views.post_date'),
                                    'placeholder' => __('general.select_date'),
                                    'name' => 'created_at',
                                    'value' => old('created_at', $insight->published_on_facebook_on->format('d/m/Y')),
                                    'required' => false,
                                    'disabled' => true,
                                ])
                        </div>

                        <div class="col-span-6 sm:col-span-3 flex items-end">
                            @include('partials.forms.button',[
                                'title' => 'Post on Facebook',
                                'url' => route('venues.create'),
                                'color' => 'indigo',
                                'icon' => '',
                                'size' => 1,
                                'extraClasses' => 'mb-2',
                                'kind' => 'primary',
                                'target' => '_self',
                            ])
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Twitter --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex">
                    <svg class="h-6 w-6 text-gray-800 inline mr-2" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 inline">Twitter</h3>
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

                        <div class="col-span-6 sm:col-span-3">
                            @include('partials.forms.inputDatePicker',[
                                    'class' => 'datepicker all',
                                    'label' => __('views.post_date'),
                                    'placeholder' => __('general.select_date'),
                                    'name' => 'created_at',
                                    'value' => old('created_at', $insight->published_on_twitter_on->format('d/m/Y')),
                                    'required' => false,
                                    'disabled' => true,
                                ])
                        </div>

                        <div class="col-span-6 sm:col-span-3 flex items-end">
                            @include('partials.forms.button',[
                                'title' => 'Post on Twitter',
                                'url' => route('venues.create'),
                                'color' => 'indigo',
                                'icon' => '',
                                'size' => 1,
                                'extraClasses' => 'mb-2',
                                'kind' => 'primary',
                                'target' => '_self',
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instagram --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex">
                    <svg class="h-6 w-6 text-gray-800 inline mr-2" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 inline">Instagram</h3>
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

                        <div class="col-span-6 sm:col-span-3">
                            @include('partials.forms.inputDatePicker',[
                                    'class' => 'datepicker all',
                                    'label' => __('views.post_date'),
                                    'placeholder' => __('general.select_date'),
                                    'name' => 'created_at',
                                    'value' => old('created_at', $insight->published_on_instagram_on->format('d/m/Y')),
                                    'required' => false,
                                    'disabled' => true,
                                ])
                        </div>

                        <div class="col-span-6 sm:col-span-3 flex items-end">
                            @include('partials.forms.button',[
                                'title' => 'Post on Instagram',
                                'url' => route('venues.create'),
                                'color' => 'indigo',
                                'icon' => '',
                                'size' => 1,
                                'extraClasses' => 'mb-2',
                                'kind' => 'primary',
                                'target' => '_self',
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
