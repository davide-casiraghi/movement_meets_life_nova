@component('mail::message')

# New treatment request

You got a treatment request from **{{$data['name']}} {{$data['surname']}}**.

Email: **{{$data['email']}}** <br>
Phone: **{{$data['phone']}}** <br>
<br>
---
<br>

## Main Complaint
{{$data['mainComplaint']}} <br>
<b>Intensity: {{$data['mainComplaintIntensity']}}</b>

<br>

## Secondary Complaint
{{$data['secondaryComplaint']}} <br>
<b>Intensity: {{$data['secondaryComplaintIntensity']}}</b>

<br><br>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
