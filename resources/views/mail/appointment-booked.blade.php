<x-mail::message>
@if($recipientRole === 'patient')


Hi {{ $appointment->patient->user->name ?? 'there' }},

Your appointment is scheduled at **{{ $appointment->hospital->hospital_name ?? 'Hospital' }}**.

**Date:** {{ $appointment->appointment_date?->format('l, d M Y') ?? '—' }}  
**Time:** {{ $appointment->time_slot }}  
**Type:** {{ $appointment->type === 'covid_test' ? 'COVID test' : 'Vaccination' }}

<x-mail::button :url="url('/Patient/Appointments')">
View my appointments
</x-mail::button>
@else
# New appointment

**Hospital:** {{ $appointment->hospital->hospital_name ?? '—' }}

**Patient:** {{ $appointment->patient->user->name ?? '—' }} ({{ $appointment->patient->user->email ?? '—' }})

**Date:** {{ $appointment->appointment_date?->format('l, d M Y') ?? '—' }}  
**Time:** {{ $appointment->time_slot }}  
**Type:** {{ $appointment->type === 'covid_test' ? 'COVID test' : 'Vaccination' }}

<x-mail::button :url="url('/Hospital/Dashboard')">
Open dashboard
</x-mail::button>
@endif

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
