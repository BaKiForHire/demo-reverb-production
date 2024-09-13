@component('mail::message')
# Latest News & Updates

{{ $content }}

@component('mail::button', ['url' => config('app.url')])
Visit Us
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
