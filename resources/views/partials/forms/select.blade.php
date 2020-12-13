{{--
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $placeholder: string - the text shown when nothing is selected
        - $tooltip: string - the content of the tooltip
        - $value: the selected value
        - $record: the content of the selected value
--}}

<label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
    Category
    @if($required)
        <span class="text-gray-500" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>
    @endif
</label>
<select id="{{ $name }}" name="{{ $name }}" autocomplete="{{ $name }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @if(!empty($emptyState)) <option value="">@if(!empty($emptyStateText)){{$emptyStateText}}@endif</option> @endif
    @foreach ($records as $value => $record)
        <option value="{{$value}}" @if(!empty($selected)) {{  $selected == $value ? 'selected' : '' }}@endif>{{ $record->name }}</option>
    @endforeach
</select>

@error($name)
    <span class="invalid-feedback text-red-500" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
@enderror
