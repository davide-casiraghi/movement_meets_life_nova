@extends('layouts.backend')

@section('buttons')
    @livewire('delete-model', [
    'model' => $tag,
    'modelName' => 'tag',
    'redirectRoute' => 'tags.index'
    ])
@endsection

@section('content')

    @include('partials.messages')
    <form class="space-y-6" method="POST" action="{{ route('tags.update',$tag->id) }}" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Edit tag</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the tag data
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
                                    'label' => __('views.tag'),
                                    'name' => 'tag',
                                    'placeholder' => 'Tag name',
                                    'value' => old('tag', $tag->tag),
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
                                            'label' => __('views.tag'),
                                            'name' => 'tag_'.$countryCode,
                                            'placeholder' => 'Tag name',
                                            'value' => old('tag_'.$countryCode, $tag->getTranslation('tag', $countryCode)),
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
                    <a href="{{ url()->previous() }}">
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
