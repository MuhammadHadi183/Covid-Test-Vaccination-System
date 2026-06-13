<x-mail::message>
# New patient request

**Hospital:** {{ $request->hospital->hospital_name ?? '—' }}

**Patient:** {{ $request->patient->user->name ?? '—' }} ({{ $request->patient->user->email ?? '—' }})

**Type:** {{ $request->request_type === 'covid_test' ? 'COVID test' : 'Vaccination' }}

@if($request->message)
**Message:**  
{{ $request->message }}
@endif

<x-mail::button :url="url('/Hospital/Requests')">
Open requests
</x-mail::button>

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
