@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Hospital Dashboard</div><div class="page-sub">{{ $Hospital->hospital_name }} — {{ now()->format('l, d F Y') }}</div></div></div>
<div class="hero-grid mb-28">
  <div class="hero-cell"><span class="hero-label">Approved Patients</span><span class="hero-value">{{ $TotalPatients }}</span></div>
  <div class="hero-cell"><span class="hero-label">Pending Requests</span><span class="hero-value">{{ $PendingRequests }}</span></div>
  <div class="hero-cell"><span class="hero-label">Today's Tests</span><span class="hero-value">{{ $TodayTests }}</span></div>
  <div class="hero-cell"><span class="hero-label">Vaccinations Done</span><span class="hero-value">{{ $TotalVaccinations }}</span></div>
</div>
<div class="col-1-1 mb-28">
  <div>
    <div class="sec-head"><span class="sec-title">Pending Requests</span></div>
    <div class="card">
      @if($RecentRequests->count() > 0)
        @foreach($RecentRequests as $R)
        <div style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid var(--border);">
          <div style="flex:1;"><div style="font-size:.83rem;font-weight:600;color:var(--primary);">{{ $R->patient?->user?->name ?? 'N/A' }}</div><div style="font-size:.73rem;color:var(--text-sub);">{{ $R->request_type === 'covid_test' ? 'COVID Test' : 'Vaccination' }} · {{ $R->created_at->format('d M') }}</div></div>
          <div class="td-actions">
            <form method="POST" action="/Hospital/Requests/{{ $R->id }}/Approve" style="margin:0;">@csrf<button class="btn btn-success btn-sm">Approve</button></form>
            <form method="POST" action="/Hospital/Requests/{{ $R->id }}/Reject" style="margin:0;">@csrf<button class="btn btn-danger btn-sm">Reject</button></form>
          </div>
        </div>
        @endforeach
      @else
        <div style="text-align:center;padding:24px;color:var(--text-light);">No pending requests</div>
      @endif
    </div>
  </div>
  <div>
    <div class="sec-head"><span class="sec-title">Vaccine Stock</span></div>
    <div class="card card-pad">
      @if($Stocks->count() > 0)
        @foreach($Stocks as $S)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
          <div><div style="font-size:.84rem;font-weight:600;">{{ $S->vaccine->name ?? 'N/A' }}</div><div style="font-size:.72rem;color:var(--text-sub);">Exp: {{ $S->expiry_date ? $S->expiry_date->format('M Y') : 'N/A' }}</div></div>
          <div style="font-size:1.1rem;font-weight:800;color:{{ $S->quantity < 100 ? 'var(--danger)' : 'var(--success)' }};">{{ $S->quantity }}</div>
        </div>
        @endforeach
      @else
        <div style="text-align:center;color:var(--text-light);">No stock data</div>
      @endif
    </div>
  </div>
</div>
<div class="mb-28">
  <div class="sec-head">
    <span class="sec-title">Today's Appointments</span>
    <a href="/Hospital/Appointments" class="sec-link">View all</a>
  </div>
  <div class="card"><div class="tbl-wrap"><table>
    <thead><tr><th>Patient</th><th>Time</th><th>Type</th><th>Status</th></tr></thead>
    <tbody>
      @if($TodayAppointments->count() > 0)
        @foreach($TodayAppointments as $A)
        <tr>
          <td class="td-patient"><strong>{{ $A->patient?->user?->name ?? 'N/A' }}</strong></td>
          <td style="font-size:.82rem;font-weight:700;">{{ $A->time_slot ?? 'N/A' }}</td>
          <td style="font-size:.79rem;">{{ $A->type === 'covid_test' ? 'COVID Test' : 'Vaccination' }}</td>
          <td><span class="badge {{ $A->status==='completed'?'badge-success':($A->status==='confirmed'?'badge-info':'badge-warning') }}">{{ ucfirst($A->status) }}</span></td>
        </tr>
        @endforeach
      @else
        <tr><td colspan="4" style="text-align:center;padding:24px;color:var(--text-light);">No appointments today</td></tr>
      @endif
    </tbody>
  </table></div></div>
</div>
@endsection
