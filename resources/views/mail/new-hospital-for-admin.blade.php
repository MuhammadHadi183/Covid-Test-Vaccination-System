<x-mail::message>
# New hospital registration

**{{ $hospital->hospital_name }}** has registered and is waiting for approval.

- **City:** {{ $hospital->city ?? '—' }}
- **Account email:** {{ $hospital->user->email ?? '—' }}

<x-mail::button :url="$approveUrl">
Approve hospital (signed link)
</x-mail::button>

This link expires in 7 days. You can still approve from the admin panel after signing in.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
