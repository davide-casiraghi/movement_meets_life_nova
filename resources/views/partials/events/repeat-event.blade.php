@section('javascript-document-ready')
    @parent

    {{-- ON LOAD --}}

    {{-- SET the week days saved - when the edit view is open  --}}
    var weekDaysSelected = $('#repeat_weekly_on').val();
    if (weekDaysSelected){
        var weekDaysSelectedArray = weekDaysSelected.split(',');
        for (i = 0; i < weekDaysSelectedArray.length; ++i) {
            $('#onWeekly label#day_'+ weekDaysSelectedArray[i]).addClass('active');
            $('#onWeekly label#day_'+ weekDaysSelectedArray[i]+' input' ).attr('checked', true);
        }
    }

    {{-- SET the repeat values, show and hide the repeat options - when the edit view is open --}}
    setRepeatValues();

    {{-- ON CHANGE --}}

    {{-- SET the repeat values, show and hide the repeat options - when repeat type is changed --}}
    $("input[name='repeat_type']").change(function(){
        setRepeatValues();
    });

    {{-- UPDATE monthly select options every time the start date is changed --}}
    $("input[name='startDate']").change(function(){
    //alert('aaa');
        updateMonthlySelectOptions();
    });


    {{-- FUNCTIONS --}}

    {{-- Show and hide the repeat options --}}
    function setRepeatValues(radioVal) {
        var radioVal = $("input[name='repeat_type']:checked").val();
        switch(radioVal) {
            case '1':  // No Repeat
                $('.repeatDetails').hide();
                $('.repeatUntilSelector').hide();
                recreateDateEnd();
            break;
            case '2':  // Repeat Weekly
                $('.repeatDetails').show();
                $('.onFrequency').hide();
                $('#onWeekly').show();
                $('.repeatUntilSelector').show();
                forceSameDateStartEnd();
            break;
            case '3':  // Repeat Monthly
                $('.repeatDetails').show();
                $('.onFrequency').hide();
                $('#onMonthly').show();
                $('.repeatUntilSelector').show();
                forceSameDateStartEnd();
            break;
            case '4':  // Repeat Multiple
                $('.repeatDetails').show();
                $('.onFrequency').hide();
                $('#onMultiple').show();
                $('.repeatUntilSelector').hide();
                forceSameDateStartEnd();
            break;
        }

    }

    {{-- Force the same date start and end (this is to avoid mistakes of the users that set date end to the end of repetition) --}}
    function forceSameDateStartEnd(){
        var dateStart = $("input[name='startDate']").val();
        $("input[name='endDate']").val(dateStart);
        $("input[name='endDate']").datepicker('destroy');
    }

    {{-- Re-create the datepicker_end_date that has been destroyed in case of repetition --}}
    function recreateDateEnd(){
        var today = new Date();
        $('#endDate input').datepicker({
            format: 'dd/mm/yyyy',
            startDate: today
        });
    }

    {{-- POPULATE the select "Monthly on" options - when the edit view is open --}}
    function updateMonthlySelectOptions(){

        var monthlyOnSelected = $("input[name='on_monthly_kind_value']").val();

        var request = $.ajax({
            url: "/event/monthSelectOptions",
            data: {
                day: $("input[name='startDate']").val()
            },
            success: function( data ) {
                $("#on_monthly_kind").html(data);
                $("#on_monthly_kind").selectpicker('refresh');
                $("#on_monthly_kind").selectpicker('val', monthlyOnSelected);
            }
        });

    }

@stop

<div class="mt-4">
    <span class="text-gray-700">@lang('event.repeat_type')</span>

    <div class="mt-2 repeatController">
        <label class="inline-flex items-center">
            <input type="radio" class="form-radio" name="repeat_type" value="1" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 1 ? 'checked' : '' }}@endif>
            <span class="ml-2">@lang('event.no_repeat')</span>
        </label>
        <label class="inline-flex items-center ml-6">
            <input type="radio" class="form-radio" name="repeat_type" value="2" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 2 ? 'checked' : '' }}@endif>
            <span class="ml-2">@lang('event.weekly')</span>
        </label>
        <label class="inline-flex items-center ml-6">
            <input type="radio" class="form-radio" name="repeat_type" value="3" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 3 ? 'checked' : '' }}@endif>
            <span class="ml-2">@lang('event.monthly')</span>
        </label>
        <label class="inline-flex items-center ml-6">
            <input type="radio" class="form-radio" name="repeat_type" value="4" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 4 ? 'checked' : '' }}@endif>
            <span class="ml-2">@lang('event.multiple')</span>
        </label>
    </div>
</div>

<div class="repeatDetails hidden mt-4">

    {{-- Weekly --}}
    <div id="onWeekly" class="onFrequency hidden">
        <label>@lang('event.weekly_on')</label>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary" id="day_1" >
                <input type="checkbox" name="repeat_weekly_on_day[]" value="1" autocomplete="off"> M
            </label>
            <label class="btn btn-primary" id="day_2">
                <input type="checkbox" name="repeat_weekly_on_day[]" value="2" autocomplete="off"> T
            </label>
            <label class="btn btn-primary" id="day_3">
                <input type="checkbox" name="repeat_weekly_on_day[]" value="3" autocomplete="off"> W
            </label>
            <label class="btn btn-primary" id="day_4">
                <input type="checkbox" name="repeat_weekly_on_day[]" value="4" autocomplete="off"> T
            </label>
            <label class="btn btn-primary" id="day_5">
                <input type="checkbox" name="repeat_weekly_on_day[]" value="5" autocomplete="off"> F
            </label>
            <label class="btn btn-primary" id="day_6">
                <input type="checkbox" name="repeat_weekly_on_day[]" value="6" autocomplete="off"> S
            </label>
            <label class="btn btn-primary" id="day_7">
                <input type="checkbox" name="repeat_weekly_on_day[]" value="7" autocomplete="off"> S
            </label>
        </div>
        <input type="hidden" name="repeat_weekly_on" id="repeat_weekly_on" @if(!empty($event->repeat_weekly_on))  value="{{$event->repeat_weekly_on}}" @endif/>
    </div>

    {{-- Monthly --}}
    <div id="onMonthly" class="onFrequency hidden">
        <label>@lang('event.monthly') *</label>
        <select name="on_monthly_kind" id="on_monthly_kind" class="selectpicker" title="@lang('general.select_repeat_monthly_kind')">
        </select>
        <input type="hidden" name="on_monthly_kind_value" @if(!empty($event->on_monthly_kind))  value="{{$event->on_monthly_kind}}" @endif/>
    </div>

    <div id="onMultiple" class="onFrequency hidden">
        @include('partials.forms.inputDatePicker',[
                    'class' => 'datepickerMultiple',
                    'name' => 'multiple_dates',
                    'label' =>  __('event.multiple_dates'),
                    'placeholder' => __('event.select_multiple_dates'),
                    'value' => $eventDateTimeParameters['multipleDates'],
                    'endDate' => '+1y',
                    'tooltipFontAwesomeClass' => 'fa fa-info-circle',
                    'tooltipText' => __('event.select_multiple_dates'),
                    'required' => false,
                ])
    </div>

    <div class="hidden repeatUntilSelector mt-4">
        @include('partials.forms.inputDatePicker', [
                  'class' => 'datepicker',
                  'label' => __('event.repeat_until'),
                  'name' => 'repeat_until',
                  'placeholder' => __('views.select_date'),
                  'value' => $eventDateTimeParameters['repeatUntil'],
                  'endDate' => '+1y',
                  'tooltipFontAwesomeClass' => 'fa fa-info-circle',
                  'tooltipText' => __('laravel-events-calendar::event.max_until'),
                  'required' => true,
            ])
    </div>


</div>