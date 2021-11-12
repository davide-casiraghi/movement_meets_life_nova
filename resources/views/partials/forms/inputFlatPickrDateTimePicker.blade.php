{{--
    Flatpikr DateTimePicker form field.


    https://blade-ui-kit.com/docs/0.x/flatpickr
    https://flatpickr.js.org/


    **The custom JS for this field is defined in:
    **resources/js/vendors/timepicker.js

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

    {{-- Required (Tooltip) --}}
    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<x-flat-pickr name="{{ $name }}"
              placeholder="{{$placeholder}}"
              format="d-m-Y H:i"
              :options="['locale' => '{firstDayOfWeek: 3}']"
              class="w-full inline shadow-sm sm:text-sm rounded-md border-gray-300 border-solid border p-2"
/>

{{--:options="['dateFormat' => 'Y-m-d', 'time_24hr'=> 'true']"--}}
