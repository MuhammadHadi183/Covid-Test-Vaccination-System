@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Hospital management</div><div class="page-sub">Directory (completed profiles), pending approvals, or full list</div></div></div>
<div class="card card-pad mb-20">
  <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:12px;">
    <span style="font-size:.72rem;font-weight:700;color:var(--text-sub);text-transform:uppercase;margin-right:6px;">View</span>
    <a href="{{ url('/Admin/Hospitals?tab=directory') }}" class="btn {{ ($Tab ?? 'directory') === 'directory' ? 'btn-primary' : 'btn-outline' }} btn-sm">Published profiles</a>
    <a href="{{ url('/Admin/Hospitals?tab=pending') }}" class="btn {{ ($Tab ?? '') === 'pending' ? 'btn-primary' : 'btn-outline' }} btn-sm">Pending approval</a>
    <a href="{{ url('/Admin/Hospitals?tab=all') }}" class="btn {{ ($Tab ?? '') === 'all' ? 'btn-primary' : 'btn-outline' }} btn-sm">All records</a>
  </div>
  @if(($Tab ?? 'directory') === 'all')
  <div style="display:flex;gap:8px;flex-wrap:wrap;">
    <a href="{{ url('/Admin/Hospitals?tab=all') }}" class="btn {{ ($Status ?? 'all') === 'all' ? 'btn-primary' : 'btn-outline' }} btn-sm">All statuses</a>
    <a href="{{ url('/Admin/Hospitals?tab=all&status=pending') }}" class="btn {{ ($Status ?? '') === 'pending' ? 'btn-primary' : 'btn-outline' }} btn-sm">Pending</a>
    <a href="{{ url('/Admin/Hospitals?tab=all&status=approved') }}" class="btn {{ ($Status ?? '') === 'approved' ? 'btn-primary' : 'btn-outline' }} btn-sm">Approved</a>
    <a href="{{ url('/Admin/Hospitals?tab=all&status=rejected') }}" class="btn {{ ($Status ?? '') === 'rejected' ? 'btn-primary' : 'btn-outline' }} btn-sm">Rejected</a>
  </div>
  @endif
</div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Hospital</th><th>City</th><th>Phone</th><th>Registration</th><th>Status</th><th>Profile</th><th>Actions</th></tr></thead>
  <tbody>
    @if($Hospitals->count() > 0)
      @foreach($Hospitals as $H)
      <tr>
        <td class="td-patient"><strong>{{ $H->hospital_name }}</strong><span>{{ $H->user->email ?? '' }}</span></td>
        <td style="font-size:.79rem;">{{ $H->city }}</td>
        <td style="font-size:.79rem;">{{ $H->phone ?? 'N/A' }}</td>
        <td class="td-mono">{{ $H->registration_no ?? 'N/A' }}</td>
        <td><span class="badge {{ $H->status==='approved'?'badge-success':($H->status==='rejected'?'badge-danger':'badge-warning') }}">{{ ucfirst($H->status) }}</span></td>
        <td><span class="badge {{ $H->profile_completed ? 'badge-info' : 'badge-neutral' }}">{{ $H->profile_completed ? 'Yes' : 'No' }}</span></td>
        <td><div class="td-actions">
          <a href="/Admin/Hospitals/{{ $H->id }}/Details" class="btn btn-outline btn-sm">View</a>
          @if($H->status === 'pending')
            <form method="POST" action="/Admin/Hospitals/{{ $H->id }}/Approve" style="margin:0;">@csrf<button class="btn btn-success btn-sm">Approve</button></form>
            <form method="POST" action="/Admin/Hospitals/{{ $H->id }}/Reject" style="margin:0;">@csrf<button class="btn btn-danger btn-sm">Reject</button></form>
          @endif
          <form method="POST" action="/Admin/Hospitals/{{ $H->id }}/Delete" style="margin:0;" onsubmit="return confirm('Delete this hospital?')">@csrf <button class="btn btn-danger btn-sm">Del</button></form>
        </div></td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text-light);">No hospitals in this view</td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Hospitals->links() }}</div>
@endsection
