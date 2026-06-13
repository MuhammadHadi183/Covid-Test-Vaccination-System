@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">My Appointments</div><div class="page-sub">Track your appointment history</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Hospital</th><th>Type</th><th>Date</th><th>Time</th><th>Status</th><th>Notes</th><th>Cancellation</th></tr></thead>
  <tbody>
    @if($Appointments->count() > 0)
      @foreach($Appointments as $appointment)
      <tr>
        <td class="td-patient"><strong>{{ $appointment->hospital->hospital_name ?? 'N/A' }}</strong></td>
        <td style="font-size:.79rem;">{{ $appointment->type === 'covid_test' ? 'COVID Test' : 'Vaccination' }}</td>
        <td style="font-size:.79rem;">{{ $appointment->appointment_date?->format('d M Y') ?? '—' }}</td>
        <td style="font-size:.82rem;font-weight:700;">{{ $appointment->time_slot ?? '—' }}</td>
        <td><span class="badge {{ $appointment->status==='completed'?'badge-success':($appointment->status==='cancelled'?'badge-danger':($appointment->status==='confirmed'?'badge-info':'badge-warning')) }}">{{ ucfirst($appointment->status) }}</span></td>
        <td style="font-size:.77rem;color:var(--text-sub);">{{ $appointment->notes ?? '—' }}</td>
        <td style="font-size:.75rem;color:var(--text-sub);max-width:200px;">{{ $appointment->status === 'cancelled' ? ($appointment->cancel_reason ?? '—') : '—' }}</td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text-light);">No appointments yet. <a href="/Patient/Book-Appointment" style="color:var(--secondary);">Book one now</a></td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Appointments->links() }}</div>
@endsection
