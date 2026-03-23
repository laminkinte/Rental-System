<x-mail::message>
# Hello {{ $name ? $name : 'Traveller' }},

Use the button below to sign in to your account. This link will expire shortly.

<x-mail::button :url="$url">
Sign in to {{ config('app.name') }}
</x-mail::button>

If you didn’t request this, you can safely ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
