<div class="mt-4">
    <span class="text-gray-700">Repeat Type</span>
    <div class="mt-2">
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