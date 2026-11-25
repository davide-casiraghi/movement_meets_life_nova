<form method="POST" action="{{ route('postComments.store') }}" >
    @csrf
    @honeypot

    <h3 class="my-4 mt-4">@lang('comment.add_a_comment')</h3>

    <input type="hidden" name="post_id" value="{{ $post->id }}">

    <div class="rounded-md shadow-xs">
        <label for="comment_body" class="block text-sm font-medium leading-5 text-gray-700">@lang('comment.your_comment')</label>
        <textarea name='body' id="comment_body" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 border border-gray-300 rounded-md shadow-xs focus:outline-hidden focus:ring-primary focus:border-primary-300">{{ old('body') }}</textarea>
    </div>

    <div class="col-span-6 sm:col-span-3 mt-2">
        <label for="comment_name" class="block text-sm font-medium leading-5 text-gray-700">@lang('comment.your_name')</label>
        <input name='name' value="{{ old('name') }}" id="comment_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-xs focus:outline-hidden focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="">
    </div>

    <div class="col-span-6 sm:col-span-3 mt-2">
        <label for="comment_email" class="block text-sm font-medium leading-5 text-gray-700">@lang('comment.your_email')</label>
        <input name='email' value="{{ old('email') }}" id="comment_email" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-xs focus:outline-hidden focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="@lang('comment.email_placeholder')">
    </div>
    <div class="block text-xs mt-1 text-gray-500">
        @lang('comment.email_notice')
    </div>

    <div class="mt-4 pt-5">
        <div class="flex justify-end">
            <span class="ml-3 inline-flex rounded-md shadow-xs">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-hidden focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    @lang('comment.publish')
                </button>
            </span>
        </div>
    </div>

</form>