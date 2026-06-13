@extends('layouts.app')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Admin Dashboard </div>
    <div class="page-sub">{{ now()->format('l, d F Y — h:i A') }}</div>
  </div>
  <div class="header-actions">
    <a href="/Admin/Reports/Export" class="btn btn-outline">Export Report</a>
  </div>
</div>

<div class="hero-grid mb-28">
  <div class="hero-cell">
    <span class="hero-label">Total Patients</span>
    <span class="hero-value">{{ number_format($TotalPatients) }}</span>
    <span class="hero-change up">Registered</span>
  </div>
  <div class="hero-cell">
    <span class="hero-label">Fully Vaccinated</span>
    <span class="hero-value">{{ number_format($TotalVaccinated) }}</span>
    <span class="hero-change up">Completed</span>
  </div>
  <div class="hero-cell">
    <span class="hero-label">Pending Requests</span>
    <span class="hero-value">{{ number_format($PendingRequests) }}</span>
    <span class="hero-change" style="color:rgba(255,255,255,.45);">Awaiting action</span>
  </div>
  <div class="hero-cell">
    <span class="hero-label">COVID Positive</span>
    <span class="hero-value">{{ number_format($PositiveTests) }}</span>
    <span class="hero-change down">Active cases</span>
  </div>
</div>

<div class="kpi-grid mb-28">
  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon" style="background:#EBF5FB;">
        <svg width="18" height="18" fill="none" stroke="#3498DB" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
    </div>
    <div class="kpi-number">{{ number_format($TotalPatients) }}</div>
    <div class="kpi-label">Registered Patients</div>
    <div class="kpi-foot">Total in system</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon" style="background:#EAFAF1;">
        <svg width="18" height="18" fill="none" stroke="#27AE60" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
    </div>
    <div class="kpi-number">{{ number_format($TotalVaccinated) }}</div>
    <div class="kpi-label">Vaccinated</div>
    <div class="kpi-foot">Completed doses</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon" style="background:#FDEDEC;">
        <svg width="18" height="18" fill="none" stroke="#E74C3C" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
      </div>
    </div>
    <div class="kpi-number">{{ number_format($PositiveTests) }}</div>
    <div class="kpi-label">COVID Positive</div>
    <div class="kpi-foot">Total positive tests</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon" style="background:#FEF9E7;">
        <svg width="18" height="18" fill="none" stroke="#F39C12" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      </div>
    </div>
    <div class="kpi-number">{{ number_format($PendingHospitals) }}</div>
    <div class="kpi-label">Pending Hospitals</div>
    <div class="kpi-foot">Awaiting approval</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon" style="background:#EBF5FB;">
        <svg width="18" height="18" fill="none" stroke="#3498DB" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
      </div>
    </div>
    <div class="kpi-number">{{ number_format($TotalTests) }}</div>
    <div class="kpi-label">Total Tests</div>
    <div class="kpi-foot">All COVID tests</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon" style="background:#EDF7F3;">
        <svg width="18" height="18" fill="none" stroke="#2C3E50" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
      </div>
    </div>
    <div class="kpi-number">{{ number_format($TotalHospitals) }}</div>
    <div class="kpi-label">Active Hospitals</div>
    <div class="kpi-foot">Approved & active</div>
  </div>
</div>

<!-- Recent Patients -->
<div class="mb-28">
  <div class="sec-head"><span class="sec-title">Recent Patient Records</span><a href="/Admin/Patients" class="sec-link">View all →</a></div>
  <div class="card">
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Patient</th><th>Email</th><th>Gender</th><th>City</th><th>Joined</th></tr></thead>
        <tbody>
          @if($RecentPatients->count() > 0)
            @foreach($RecentPatients as $P)
            <tr>
              <td class="td-patient"><strong>{{ $P->user->name ?? 'N/A' }}</strong><span>{{ $P->cnic ?? 'No CNIC' }}</span></td>
              <td style="font-size:.79rem;">{{ $P->user->email ?? 'N/A' }}</td>
              <td style="font-size:.79rem;">{{ ucfirst($P->gender ?? 'N/A') }}</td>
              <td style="font-size:.79rem;">{{ $P->city ?? 'N/A' }}</td>
              <td style="font-size:.77rem;color:var(--text-sub);">{{ $P->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
          @else
            <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--text-light);">No patients yet</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Recent COVID Tests -->
<div class="mb-28">
  <div class="sec-head"><span class="sec-title">COVID-19 Test Results — Today</span><a href="/Admin/Reports" class="sec-link">Full reports →</a></div>
  <div class="card">
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Patient</th><th>Type</th><th>Result</th><th>CT Value</th><th>Hospital</th><th>Date</th></tr></thead>
        <tbody>
          @if($RecentTests->count() > 0)
            @foreach($RecentTests as $T)
            <tr>
              <td class="td-patient"><strong>{{ $T->patient->user->name ?? 'N/A' }}</strong></td>
              <td style="font-size:.79rem;">{{ $T->test_type }}</td>
              <td>
                @if($T->result === 'positive') <span class="badge badge-danger">Positive</span>
                @elseif($T->result === 'negative') <span class="badge badge-success">Negative</span>
                @else <span class="badge badge-warning">Pending</span>
                @endif
              </td>
              <td style="font-size:.82rem;">{{ $T->ct_value ?? 'N/A' }}</td>
              <td style="font-size:.78rem;">{{ $T->hospital->hospital_name ?? 'N/A' }}</td>
              <td style="font-size:.77rem;color:var(--text-sub);">{{ $T->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
          @else
            <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--text-light);">No test results yet</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Vaccine Inventory -->
<div class="mb-28">
  <div class="sec-head"><span class="sec-title">Vaccine Inventory</span><a href="/Admin/Vaccines" class="sec-link">Manage →</a></div>
  <div class="card card-pad">
    @if($Vaccines->count() > 0)
      @foreach($Vaccines as $V)
      <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
        <div>
          <div style="font-size:.84rem;font-weight:600;color:var(--primary);">{{ $V->name }}</div>
          <div style="font-size:.72rem;color:var(--text-sub);">{{ $V->manufacturer }} · {{ $V->doses_required }} doses</div>
        </div>
        <span class="badge {{ $V->status === 'available' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($V->status) }}</span>
      </div>
      @endforeach
    @else
      <div style="text-align:center;padding:24px;color:var(--text-light);">No vaccines added yet</div>
    @endif
  </div>
</div>
@endsection
