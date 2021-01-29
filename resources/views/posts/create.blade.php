@extends('layouts.backend')

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Create post</h3>
              <p class="mt-1 text-sm text-gray-500">
                {{--Create a post--}}
              </p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                @include('partials.messages')

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('views.title'),
                                'name' => 'title',
                                'placeholder' => 'Post title',
                                'value' => old('title'),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.select', [
                            'label' => __('views.category'),
                            'name' => 'category_id',
                            'placeholder' => __('views.select_category'),
                            'records' => $categories,
                            /*'selected' => $post->category_id,*/
                            'required' => true,
                            'extraClasses' => '',
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                                'label' => __('views.before_post_contents'),
                                'name' => 'before_content',
                                'placeholder' => '',
                                'value' =>  old('before_content'),
                                'required' => false,
                                'disabled' => false,
                                'style' => 'plain',
                                'extraDescription' => 'Anything to show jumbo style before the content',
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
                        @include('partials.forms.textarea', [
                                'label' => __('views.after_post_contents'),
                                'name' => 'after_content',
                                'placeholder' => '',
                                'value' => old('after_content'),
                                'required' => false,
                                'disabled' => false,
                                'style' => 'plain',
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
                            //'selected' => $post->tags->modelKeys(),
                            'required' => TRUE,
                            'extraClasses' => '',
                        ])
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="flex justify-end mt-4">
          <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Cancel
          </button>
          <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Save
          </button>
        </div>
    </form>

@endsection
