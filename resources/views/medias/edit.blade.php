@extends('layouts.backend')

@section('title')
    Static pages media manager
@endsection

@section('buttons')

@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('medias.update',$post->id) }}" enctype="multipart/form-data" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        @csrf
        @method('PUT')

        {{-- Post contents --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">

                @include('partials.forms.inputHidden', [
                      'name' => 'title',
                      'value' => $post->title
                ])

                @include('partials.forms.inputHidden', [
                      'name' => 'intro_text',
                      'value' => $post->intro_text
                ])

                @include('partials.forms.inputHidden', [
                      'name' => 'body',
                      'value' => $post->body
                ])

                @include('partials.forms.inputHidden', [
                      'name' => 'category_id',
                      'value' => $post->category_id
                ])

                @include('partials.forms.inputHidden', [
                      'name' => 'user_id',
                      'value' => $post->user_id
                ])

                <div class="col-span-6">
                    @include('partials.forms.uploadImageMultiple', [
                              'label' => __('views.images_for_galleries'),
                              'name' => 'images',
                              'required' => false,
                              'collection' => 'images',
                              'model' => $post,
                          ])
                </div>

            </div>
        </div>

        <div class="grid grid-cols-6 gap-6">

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
