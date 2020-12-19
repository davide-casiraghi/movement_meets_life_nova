{{--
    TimePicker form field.

    Vanilla Javascript Timepicker
    by Lance Jernigan
    https://codepen.io/Lance-Jernigan/pen/jARLLO


    The custom JS for this field is defined in:
    resources/js/vendors/timepicker.js

    PARAMETERS:
        - $class: string - the class related to the js that activate the datepicker
        - $label: optional label to show above the field
        - $placeholder
        - $name: input the field name
        - $value: the value of the field
        - $endDate: To set a limit to the selectable days eg. '+1y'

--}}




@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<input
        type="text"
        class="timepicker focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md"

        name="{{ $name }}"
        id="{{ $name }}"
        @if(!empty($value)) value="{{ $value }}" @endif

/>