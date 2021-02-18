@extends('layouts.backend')

@section('title')
    @lang('views.edit_quote')
@endsection

@section('buttons')
    @livewire('delete-model', [
    'model' => $quote,
    'modelName' => 'quote',
    'redirectRoute' => 'quotes.index'
    ])
@endsection

@section('content')

    @include('partials.messages')
    <form class="space-y-6" method="POST" action="{{ route('quotes.update',$quote->id) }}" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    {{--<h3 class="text-lg font-medium leading-6 text-gray-900">Edit quote</h3>--}}
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
                    @method('PUT')

                    {{-- Translations tabs - Default Contents --}}
                    <div class="translation en" x-show.transition.in="translationActive === '{{Config::get('app.fallback_locale')}}'">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                @include('partials.forms.input', [
                                        'label' => __('views.author'),
                                        'name' => 'author',
                                        'placeholder' => 'Author',
                                        'value' => old('author', $quote->author),
                                        'required' => true,
                                        'disabled' => false,
                                ])
                            </div>

                            <div class="col-span-6">
                                @include('partials.forms.input', [
                                        'label' => __('general.description'),
                                        'name' => 'description',
                                        'placeholder' => 'Description',
                                        'value' => old('description', $quote->description),
                                        'required' => true,
                                        'disabled' => false,
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
                                                'value' => old('description_'.$countryCode, $quote->getTranslation('description', $countryCode)),
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
