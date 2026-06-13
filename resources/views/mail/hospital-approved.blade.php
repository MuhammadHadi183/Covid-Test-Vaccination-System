<x-mail::message>
# Account approved

Hello,

**{{ $hospital->hospital_name }}** is now **approved**. You can sign in and complete your public profile so patients can find you.

<x-mail::button :url="url('/login')">
Sign in
</x-mail::button>

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
