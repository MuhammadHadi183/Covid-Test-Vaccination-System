@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Approved Patients</div><div class="page-sub">Patients approved for COVID-19 tests</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Request Type</th><th>Message</th><th>Date</th></tr></thead>
  <tbody>
    @if($Patients->count() > 0)
      @foreach($Patients as $patientRequest)
      <tr>
        <td class="td-patient"><strong>{{ $patientRequest->patient?->user?->name ?? 'N/A' }}</strong><span>{{ $patientRequest->patient?->user?->email ?? '' }}</span></td>
        <td style="font-size:.79rem;">{{ $patientRequest->request_type === 'covid_test' ? 'COVID Test' : 'Vaccination' }}</td>
        <td style="font-size:.79rem;">{{ $patientRequest->message ?? '—' }}</td>
        <td style="font-size:.77rem;color:var(--text-sub);">{{ $patientRequest->created_at->format('d M Y') }}</td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="4" style="text-align:center;padding:24px;color:var(--text-light);">No approved patients</td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Patients->links() }}</div>
@endsection
