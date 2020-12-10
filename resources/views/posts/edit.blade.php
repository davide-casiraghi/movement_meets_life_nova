@extends('layouts.backend')


@section('javascript')
    @parent
    @include('partials.helpers.tinyMceJavascript')
@stop

@section('content')

<form class="space-y-6" method="POST" action="{{ route('posts.update',$post->id) }}">
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Edit post</h3>
          <p class="mt-1 text-sm text-gray-500">
            {{--Edit the post data--}}
          </p>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">

            @csrf
            @method('PUT')


            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6">
                    @include('partials.forms.input', [
                            'title' => __('ui.posts.title'),
                            'name' => 'title',
                            'placeholder' => 'Post title',
                            'value' => old('title', $post->title),
                            'required' => true,
                            'disabled' => false,
                    ])
                </div>

                <div class="col-span-6 sm:col-span-4">
                    @include('partials.forms.input', [
                            'title' => __('ui.posts.link_to_this_post'),
                            'name' => 'post_link',
                            'placeholder' => '',
                            'value' => env('APP_URL').'post/'.$post->slug,
                            'required' => false,
                            'disabled' => true,
                        ])
                </div>

                <div class="col-span-6 sm:col-span-2">
                    @include('partials.forms.input', [
                            'title' => __('ui.posts.post_id'),
                            'name' => 'post_id',
                            'placeholder' => '',
                            'value' => $post->id,
                            'required' => false,
                            'disabled' => true,
                        ])
                </div>

                <div class="col-span-6">
                    @include('partials.forms.select', [
                        'title' => __('ui.posts.category'),
                        'name' => 'category_id',
                        'placeholder' => __('ui.posts.select_category'),
                        'records' => $categories,
                        'selected' => $post->category_id,
                        'required' => true,
                    ])
                    {{--<label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category" name="category_id" autocomplete="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{ old('category_id',$post->category_id) == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                        @endforeach
                    </select>--}}
                </div>

                <div class="col-span-6">
                    <label for="about" class="block text-sm font-medium text-gray-700">
                        Before the article content
                    </label>
                    <div class="mt-1">
                        <textarea id="before_content" name="before_content" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="you@example.com">{{$post->before_content}}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Anything to show jumbo style before the content
                    </p>
                </div>

                <div class="col-span-6">
                    <label for="about" class="block text-sm font-medium text-gray-700">
                        Text
                    </label>
                    <div class="mt-1">
                        <textarea id="body" name="body" rows="6" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="you@example.com">{{$post->body}}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        The post body
                    </p>
                </div>

                <div class="col-span-6">
                    <label for="about" class="block text-sm font-medium text-gray-700">
                        After the article content
                    </label>
                    <div class="mt-1">
                        <textarea id="after_content" name="after_content" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="you@example.com">{{$post->after_content}}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Anything to show jumbo style after the content
                    </p>
                </div>

                <div class="col-span-6">
                  <label class="block text-sm font-medium text-gray-700">
                    Photo
                  </label>
                  <div class="mt-2 flex items-center space-x-5">
                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                      <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                      </svg>
                    </span>
                    <button type="button" class="bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      Change
                    </button>
                  </div>
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
