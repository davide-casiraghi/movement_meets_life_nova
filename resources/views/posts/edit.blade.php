@extends('layouts.backend')

@section('content')

<div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
  <div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
      <h3 class="text-lg font-medium leading-6 text-gray-900">Edit post</h3>
      <p class="mt-1 text-sm text-gray-500">
        {{--Edit the post data--}}
      </p>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-2">
      <form class="space-y-6" action="#" method="POST">
        
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" autocomplete="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            
            <div class="col-span-6 sm:col-span-4">
                <label for="post_link" class="block text-sm font-medium text-gray-700">Link to this post</label>
                <input type="text" name="post_link" id="post_link" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="col-span-6 sm:col-span-2">
                <label for="post_id" class="block text-sm font-medium text-gray-700">Post ID</label>
                <input type="text" name="post_id" id="post_id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            
            <div class="col-span-6">
                <label for="country" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option>United States</option>
                    <option>Canada</option>
                    <option>Mexico</option>
                </select>
            </div>
            
            <div class="col-span-6">
                <label for="about" class="block text-sm font-medium text-gray-700">
                    Before the article content
                </label>
                <div class="mt-1">
                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="you@example.com"></textarea>
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
                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="you@example.com"></textarea>
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
                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="you@example.com"></textarea>
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
      </form>
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





@endsection
