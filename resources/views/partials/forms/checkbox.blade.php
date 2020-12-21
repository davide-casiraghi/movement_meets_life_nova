{{--
    PARAMETERS:
        - $label: string - the label to show
        - $name: string - the select name attribute
        - $description: string - the description to show under the label
        - $value: the selected value
--}}


{{--
Wrap the checkboxes in a
<div class="relative flex items-start">

if you want on multiple lines create many
<div class="relative flex items-start">

othewrise put all of them in the same if you want inline

--}}


<label class="inline-flex items-center mr-6 mb-1">
    <input id="{{$id}}"
           name="{{$name}}"
           type="checkbox"
           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded @if ($errors->has($name)) border-red-500 @endif"
           {{--value="{{$value}}"--}}
            {{$checked}}
    >
    <span class="ml-2">
        {{$label}}
    </span>
</label>

@error($name)
    <span class="invalid-feedback text-red-500" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
@enderror
