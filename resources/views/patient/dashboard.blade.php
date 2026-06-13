@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Welcome, {{ Auth::user()->name }} </div><div class="page-sub">{{ now()->format('l, d F Y') }}</div></div></div>
<div class="kpi-grid mb-28">
  <div class="kpi-card"><div class="kpi-top"><div class="kpi-icon" style="background:#EBF5FB;"><svg width="18" height="18" fill="none" stroke="#3498DB" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg></div></div><div class="kpi-number">{{ $UpcomingAppointments->count() }}</div><div class="kpi-label">Upcoming Appointments</div></div>
  <div class="kpi-card"><div class="kpi-top"><div class="kpi-icon" style="background:#EAFAF1;"><svg width="18" height="18" fill="none" stroke="#27AE60" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></div><div class="kpi-number">{{ $VaccinationRecords->count() }}</div><div class="kpi-label">Vaccinations Done</div></div>
  <div class="kpi-card"><div class="kpi-top"><div class="kpi-icon" style="background:#FDEDEC;"><svg width="18" height="18" fill="none" stroke="#E74C3C" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div></div><div class="kpi-number">{{ $RecentResults->count() }}</div><div class="kpi-label">Recent Tests</div></div>
  <div class="kpi-card"><div class="kpi-top"><div class="kpi-icon" style="background:#FEF9E7;"><svg width="18" height="18" fill="none" stroke="#F39C12" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div></div><div class="kpi-number">{{ $PendingRequests }}</div><div class="kpi-label">Pending Requests</div></div>
</div>
<div class="col-1-1 mb-28">
  <div>
    <div class="sec-head"><span class="sec-title">Upcoming Appointments</span><a href="/Patient/Appointments" class="sec-link">View all →</a></div>
    <div class="card">
      @if($UpcomingAppointments->count() > 0)
        @foreach($UpcomingAppointments as $A)
        <div style="display:flex;align-items:center;gap:14px;padding:12px 20px;border-bottom:1px solid var(--border);">
          <div style="text-align:right;width:58px;"><div style="font-size:.9rem;font-weight:700;color:var(--primary);">{{ $A->appointment_date->format('d M') }}</div><div style="font-size:.67rem;color:var(--text-sub);">{{ $A->time_slot }}</div></div>
          <div style="width:3px;height:36px;border-radius:2px;background:var(--secondary);"></div>
          <div style="flex:1;"><div style="font-size:.83rem;font-weight:600;color:var(--primary);">{{ $A->hospital->hospital_name ?? 'N/A' }}</div><div style="font-size:.72rem;color:var(--text-sub);">{{ $A->type === 'covid_test' ? 'COVID Test' : 'Vaccination' }}</div></div>
          <span class="badge {{ $A->status==='confirmed'?'badge-success':'badge-warning' }}">{{ ucfirst($A->status) }}</span>
        </div>
        @endforeach
      @else
        <div style="text-align:center;padding:24px;color:var(--text-light);">No upcoming appointments</div>
      @endif
    </div>
  </div>
  <div>
    <div class="sec-head"><span class="sec-title">Recent Test Results</span><a href="/Patient/Results" class="sec-link">View all →</a></div>
    <div class="card">
      @if($RecentResults->count() > 0)
        @foreach($RecentResults as $R)
        <div style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid var(--border);">
          <div style="flex:1;"><div style="font-size:.83rem;font-weight:600;color:var(--primary);">{{ $R->test_type }}</div><div style="font-size:.73rem;color:var(--text-sub);">{{ $R->hospital->hospital_name ?? 'N/A' }} · {{ $R->created_at->format('d M Y') }}</div></div>
          <span class="badge {{ $R->result==='positive'?'badge-danger':($R->result==='negative'?'badge-success':'badge-warning') }}">{{ ucfirst($R->result) }}</span>
        </div>
        @endforeach
      @else
        <div style="text-align:center;padding:24px;color:var(--text-light);">No test results yet</div>
      @endif
    </div>
  </div>
</div>
@endsection
