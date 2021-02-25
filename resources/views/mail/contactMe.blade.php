@component('mail::message')
# Message from the contact form

Message from <b>{{$data['name']}} {{$data['surname']}}</b>

{{$data['message']}} <br><br>

{{$data['email']}} <br>

@component('mail::button', ['url' => '#'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
