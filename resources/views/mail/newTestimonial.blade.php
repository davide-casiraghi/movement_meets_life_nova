@component('mail::message')
# You got a new testimonial

<b>{{$data['name']}} {{$data['surname']}}</b> is willing to become your testimonial. <br><br>
{{$data['profession']}} <br><br>

{{$data['feedback']}} <br><br>

@component('mail::button', ['url' => '#']) {{-- config('app.url') }}/alert/{{$alert->id --}}
    Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
