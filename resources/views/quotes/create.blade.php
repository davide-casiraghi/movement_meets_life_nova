@extends('layouts.backend')

@section('content')

    @include('partials.messages')
    <form class="space-y-6" method="POST" action="{{ route('quotes.store') }}" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Create quote</h3>
                    {{--
                      <p class="mt-1 text-sm text-gray-500">
                        Edit the quote data
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
                                        'label' => __('views.author'),
                                        'name' => 'author',
                                        'placeholder' => 'Author',
                                        'value' => old('author'),
                                        'required' => true,
                                        'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6">
                                @include('partials.forms.input', [
                                        'label' => __('general.description'),
                                        'name' => 'description',
                                        'placeholder' => 'Description',
                                        'value' => old('description'),
                                        'required' => true,
                                        'disabled' => false,
                                ])
                            </div>

                            {{-- Show where --}}
                            <div class="col-span-6">
                                <h2 class="mb-2">Show where</h2>
                                <div class="text-sm text-gray-500">
                                    You can decide to show it in frontend, backend or both.
                                </div>

                                <select name="show_where" class="mt-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @if ($errors->has('question_type')) border-red-500 @endif">
                                    <option value="">Choose...</option>
                                    <option value="frontend" {{ old('show_where') == 'frontend' ? 'selected' : ''}}>Frontend</option>
                                    <option value="backend" {{ old('show_where') == 'backend' ? 'selected' : ''}}>Backend</option>
                                    <option value="both" {{ old('show_where') == 'both' ? 'selected' : ''}}>Both</option>
                                </select>
                                @error('show_where')
                                <span class="invalid-feedback text-red-500" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Published --}}
                            <div class="col-span-6">
                                @include('partials.forms.checkbox', [
                                    'label' => __('views.published'),
                                    'id'  => 'is_published',
                                    'name' => 'is_published',
                                    'size' => 'small',
                                    'required' => false,
                                    'checked' => '',
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
                                                'label' => __('general.description'),
                                                'name' => 'description_'.$countryCode,
                                                'placeholder' => 'Description',
                                                'value' => old('description_'.$countryCode),
                                                'required' => true,
                                                'disabled' => false,
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
            <div class="col-span-6">
                <div class="flex justify-end mt-4">
                    <a href="{{ route('quotes.index') }}">
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
