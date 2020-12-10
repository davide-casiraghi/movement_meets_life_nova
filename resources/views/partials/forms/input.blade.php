{{--
    INPUT form field

    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the table field name
        - $placeholder: string - the placeholder to show when no date selected
        - $tooltip: string - the content of the tooltip
        - $value: the already stored value (used in edit view to retrieve the already stored value)
        - $hide: if true
--}}

<label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
    {{ $title }}
    @if($required)
        <span class="gray-5" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>
    @endif
</label>
<input type="text"
       name="{{ $name }}"
       id="{{ $name }}"
       autocomplete="{{ $name }}"
       @if(!empty($placeholder)) placeholder="{{ $placeholder }}" aria-label="{{ $placeholder }}" @endif
       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md
              border-gray-300 @if ($errors->has($name)) border-red-500 @endif"
       value="{{ $value ?? '' }}"
>

@error($name)
    <span class="invalid-feedback text-red-500" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
@enderror

{{--



<div class="form-group {{ $name }}" @if( !empty($hide)) style="display:none;" @endif>
    @if(!empty($title))
        <label for="{{ $name }}">{{ $title }}@if($required) <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>@endif</label>
        @if(!empty($tooltip))<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}"></i>@endif
    @endif

    <input type="text" name="{{ $name }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
           @if(!empty($placeholder)) placeholder="{{ $placeholder }}" aria-label="{{ $placeholder }}" @endif
           @if(!empty($value)) value="{{ $value }}" @endif
    >

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
--}}
