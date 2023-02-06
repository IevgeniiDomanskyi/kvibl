@component('mail::message')

Please click <a href="{{$url}}">link</a> to verify your account

Thanks,<br>
{{ config('app.name') }}
@endcomponent
