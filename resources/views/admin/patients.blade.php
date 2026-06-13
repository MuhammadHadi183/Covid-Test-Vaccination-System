@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">All Patients</div><div class="page-sub">View and manage registered patients</div></div>
<div class="header-actions"><a href="/Admin/Patients/Create" class="btn btn-primary">+ Add Patient</a></div></div>
<div class="card card-pad mb-20">
  <form method="GET" action="/Admin/Patients" style="display:flex;gap:10px;">
    <input type="text" name="search" class="form-input" placeholder="Search by name, email or CNIC..." value="{{ request('search') }}" style="max-width:400px;">
    <button type="submit" class="btn btn-primary">Search</button>
  </form>
</div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Name</th><th>Email</th><th>CNIC</th><th>Gender</th><th>City</th><th>Blood</th><th>Joined</th><th>Actions</th></tr></thead>
  <tbody>
    @if($Patients->count() > 0)
      @foreach($Patients as $P)
      <tr>
        <td class="td-patient"><strong>{{ $P->user->name ?? 'N/A' }}</strong><span>{{ $P->user->phone ?? '' }}</span></td>
        <td style="font-size:.79rem;">{{ $P->user->email ?? 'N/A' }}</td>
        <td class="td-mono">{{ $P->cnic ?? 'N/A' }}</td>
        <td style="font-size:.79rem;">{{ ucfirst($P->gender ?? 'N/A') }}</td>
        <td style="font-size:.79rem;">{{ $P->city ?? 'N/A' }}</td>
        <td style="font-size:.79rem;">{{ $P->blood_group ?? 'N/A' }}</td>
        <td style="font-size:.77rem;color:var(--text-sub);">{{ $P->created_at->format('d M Y') }}</td>
        <td><div class="td-actions">
          <a href="/Admin/Patients/{{ $P->id }}/Edit" class="btn btn-outline btn-sm">Edit</a>
          <form method="POST" action="/Admin/Patients/{{ $P->id }}/Delete" style="margin:0;" onsubmit="return confirm('Delete this patient?')">@csrf <button class="btn btn-danger btn-sm">Del</button></form>
        </div></td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="8" style="text-align:center;padding:24px;color:var(--text-light);">No patients found</td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Patients->links() }}</div>
@endsection
