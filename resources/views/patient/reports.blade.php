@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">View Results</div><div class="page-sub">COVID-19 test results and vaccination details</div></div></div>

<!-- COVID Test Results -->
<div class="mb-28">
  <div class="sec-head"><span class="sec-title">COVID-19 Test Results</span></div>
  <div class="card"><div class="tbl-wrap"><table>
    <thead><tr><th>Test Type</th><th>Result</th><th>CT Value</th><th>Hospital</th><th>Date</th></tr></thead>
    <tbody>
      @if($Tests->count() > 0)
        @foreach($Tests as $T)
        <tr>
          <td style="font-size:.82rem;font-weight:600;">{{ $T->test_type }}</td>
          <td><span class="badge {{ $T->result==='positive'?'badge-danger':($T->result==='negative'?'badge-success':'badge-warning') }}">{{ ucfirst($T->result) }}</span></td>
          <td style="font-size:.82rem;">{{ $T->ct_value ?? 'N/A' }}</td>
          <td style="font-size:.79rem;">{{ $T->hospital->hospital_name ?? 'N/A' }}</td>
          <td style="font-size:.77rem;color:var(--text-sub);">{{ $T->created_at->format('d M Y H:i') }}</td>
        </tr>
        @endforeach
      @else
        <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--text-light);">No test results</td></tr>
      @endif
    </tbody>
  </table></div></div>
</div>

<!-- Vaccination Records -->
<div class="mb-28">
  <div class="sec-head"><span class="sec-title">Vaccination Records</span></div>
  <div class="card"><div class="tbl-wrap"><table>
    <thead><tr><th>Vaccine</th><th>Dose</th><th>Status</th><th>Hospital</th><th>Date</th></tr></thead>
    <tbody>
      @if($Vaccinations->count() > 0)
        @foreach($Vaccinations as $V)
        <tr>
          <td style="font-size:.82rem;font-weight:600;">{{ $V->vaccine->name ?? 'N/A' }}</td>
          <td style="font-size:.79rem;">Dose {{ $V->dose_number }}</td>
          <td><span class="badge {{ $V->status==='completed'?'badge-success':($V->status==='cancelled'?'badge-danger':'badge-warning') }}">{{ ucfirst($V->status) }}</span></td>
          <td style="font-size:.79rem;">{{ $V->hospital->hospital_name ?? 'N/A' }}</td>
          <td style="font-size:.77rem;color:var(--text-sub);">{{ $V->vaccinated_at ? $V->vaccinated_at->format('d M Y') : 'Pending' }}</td>
        </tr>
        @endforeach
      @else
        <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--text-light);">No vaccination records</td></tr>
      @endif
    </tbody>
  </table></div></div>
</div>
@endsection
