@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Patient Requests</div><div class="page-sub">Approve or reject COVID test/vaccination requests</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Type</th><th>Message</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
  <tbody>
    @if($Requests->count() > 0)
      @foreach($Requests as $request)
      <tr>
        <td class="td-patient"><strong>{{ $request->patient?->user?->name ?? 'N/A' }}</strong></td>
        <td style="font-size:.79rem;">{{ $request->request_type === 'covid_test' ? 'COVID Test' : 'Vaccination' }}</td>
        <td style="font-size:.79rem;">{{ $request->message ?? '—' }}</td>
        <td><span class="badge {{ $request->status==='approved'?'badge-success':($request->status==='rejected'?'badge-danger':'badge-warning') }}">{{ ucfirst($request->status) }}</span></td>
        <td style="font-size:.77rem;color:var(--text-sub);">{{ $request->created_at->format('d M Y') }}</td>
        <td><div class="td-actions">
          @if($request->status === 'pending')
            <form method="POST" action="/Hospital/Requests/{{ $request->id }}/Approve" style="margin:0;">@csrf<button class="btn btn-success btn-sm">Approve</button></form>
            <form method="POST" action="/Hospital/Requests/{{ $request->id }}/Reject" style="margin:0;">@csrf<button class="btn btn-danger btn-sm">Reject</button></form>
          @else
            <span style="font-size:.75rem;color:var(--text-light);">—</span>
          @endif
        </div></td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--text-light);">No requests</td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Requests->links() }}</div>
@endsection
