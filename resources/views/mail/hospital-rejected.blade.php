<x-mail::message>
# Registration update

Hello,

We are writing about **{{ $hospital->hospital_name }}**. Your registration was not approved at this time.

If you believe this is a mistake, please contact support using the contact details on our website.

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
