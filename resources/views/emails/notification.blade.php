@component('mail::message')
# {{ $notification->title }}

{{ $notification->message }}

@if($notification->data)
    @component('mail::panel')
    @foreach($notification->data as $key => $value)
        **{{ ucfirst($key) }}:** {{ $value }}
    @endforeach
    @endcomponent
@endif

@component('mail::button', ['url' => config('app.url')])
View in JubbaStay
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
