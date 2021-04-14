@component('mail::message')

# New treatment request

You got a treatment request from **{{$data['name']}} {{$data['surname']}}**.

Email: {{$data['email']}} <br>
Phone: {{$data['phone']}} <br>
<br>
---
<br>

## Main Complaint
{{$data['mainComplaint']}} <br>
<b>Intensity:</b> {{$data['mainComplaintIntensity']}}

<br>

## Secondary Complaint
{{$data['secondaryComplaint']}} <br>
<b>Intensity:</b> {{$data['secondaryComplaintIntensity']}}

<br><br>

## I prefer to be contacted by
{{$data['contactChoice']}}

{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
