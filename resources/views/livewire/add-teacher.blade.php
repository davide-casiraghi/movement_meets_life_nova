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

    <div class="md:grid md:grid-cols-6 md:gap-6">
        <div class="md:col-span-4">
            <label for="teacher_ids" class="block text-sm font-medium text-gray-700 inline">{{__('general.teachers')}}</label>

            <select id="teacher_ids" name="teacher_ids[]" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple='multiple'>
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
        <div class="md:col-span-2 relative">
            <button wire:click.prevent="edit" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 absolute bottom-1 left-1">
                Add teacher
            </button>
        </div>
    </div>

    

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
