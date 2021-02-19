<div wire:ignore>
    {{--@include('partials.forms.select_multiple', [
        'label' => __('general.teachers'),
        'name' => 'teacher_ids',
        'placeholder' => __('event.select_teachers'),
        'records' => $teachers,
        'value_attribute_name' => 'full_name',
        'selected' => old('teacher_ids'),
        'required' => false,
        'extraClasses' => '',
    ])--}}


    
    <label for="teacher_ids" class="block text-sm font-medium text-gray-700 inline">{{__('general.teachers')}}</label>

    <select id="teacher_ids" name="teacher_ids[]" {{--autocomplete="teacher_ids"--}} class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple='multiple'>
        <option value="" class="text-gray-500">{{__('event.select_teachers')}}</option>

        @if(!empty($teachers))
            @foreach ($teachers as $key => $teacher)
                @isset($selected)
                    <option value="{{$teacher->id}}" {{ in_array($teacher->id, $selected) ? "selected":"" }}>{{$teacher->full_name}}</option>
                @else
                    <option value="{{$teacher->id}}">{{$teacher->full_name}}</option>
                @endif
            @endforeach
        @endif
    </select>

    @error('teacher_ids')
    <span class="invalid-feedback text-red-500" role="alert">
        <strong>{{ $errors->first('teacher_ids') }}</strong>
    </span>
    @enderror
</div>


@push('scripts')
    <script>

        $(document).ready(function () {
            //console.log('ciao bello');

            $('#teacher_ids').select2();
            $('#teacher_ids').on('change', function (e) {

                var data = $('#teacher_ids').select2("val");
                //console.log(data);

                @this.set('selected', data);
            });
        });
        
    </script>
@endpush
