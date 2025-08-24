<x-mail::message>
    Hello {{ $client->name }},

    You are receiving this email because we received a password reset request for your account.<br> If you did not request a password reset, no further action is required.

    This is your verification code: {{ $code }}

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
