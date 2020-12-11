

<label class="block text-sm leading-5 font-medium text-gray-700">
    {{ $title }}
</label>
<div class="mt-2 flex items-center">
    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">

        @if(empty($value))
            {{-- Show the Placeholder --}}
            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>

            @else
            {{-- Show the Image that has been already stored --}}
            <div class="col-12 col-sm-4 col-md-4">
                @if(!is_null($post->getMedia('post')->first()))
                    <img class="uploadedImage" style="width: 100%" src="{{$post->getMedia('post')->first()->getUrl('thumb')}}" alt="">
                @endif
            </div>

            {{-- Show the image name to use in the edit view to not delete the image on update --}}
            @include('partials.forms.inputHidden', [
                  'name' => $name,
                  'value' => $value
            ])

        @endif
    </span>
    <span class="ml-5 rounded-md shadow-sm">
        <label class="py-2 px-3 border border-gray-300 rounded-md text-xs leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
            <span class="mt-2 text-base leading-normal">Select a file</span>
            <input type='file' name="{{$name}}" class="hidden" />
        </label>
        @if(!empty($value))
        <label class="ml-3 py-2 px-3 border border-gray-300 rounded-md text-xs leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
            <span class="mt-2 text-base leading-normal">
                <i class="far fa-trash-alt"></i>
                Delete image
            </span>
        </label>
        @endif
    </span>
</div>