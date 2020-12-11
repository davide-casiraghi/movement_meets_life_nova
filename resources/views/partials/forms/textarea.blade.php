{{--
    TEXTAREA without tinymce editor.
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $placeholder: string - the text shown when no text present
        - $value: the already stored value (used in edit view to retrieve the already stored value)
        - $style: plain|tinymce
--}}

<label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
    {{ $title }}
    @if($required)
        <span class="text-gray-500" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>
    @endif
</label>

<div class="mt-1">
    <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="3"
            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md
                    @if ($errors->has($name)) border-red-500 @endif
                    @if ($disabled) bg-gray-200 @endif
                    @if ($style == 'tinymce') textarea_tinymce @endif
                    "
            @if(!empty($placeholder))
                placeholder="{{ $placeholder }}"
                aria-label="{{ $placeholder }}"
           @endif
    >{{ $value ?? '' }}</textarea>
</div>
@if(!empty($extraDescription))
    <p class="mt-2 text-sm text-gray-500">
        {{$extraDescription}}
    </p>
@endif