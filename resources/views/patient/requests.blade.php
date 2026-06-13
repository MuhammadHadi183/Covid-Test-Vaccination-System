@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">My requests</div><div class="page-sub">Requests you sent to hospitals and their status</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Hospital</th><th>Type</th><th>Your message</th><th>Status</th><th>Date</th></tr></thead>
  <tbody>
    @if($Requests->count() > 0)
      @foreach($Requests as $request)
      <tr>
        <td class="td-patient"><strong>{{ $request->hospital?->hospital_name ?? 'N/A' }}</strong></td>
        <td style="font-size:.79rem;">{{ $request->request_type === 'covid_test' ? 'COVID test' : 'Vaccination' }}</td>
        <td style="font-size:.77rem;color:var(--text-sub);max-width:220px;">{{ $request->message ?? '—' }}</td>
        <td><span class="badge {{ $request->status==='approved'?'badge-success':($request->status==='rejected'?'badge-danger':'badge-warning') }}">{{ ucfirst($request->status) }}</span></td>
        <td style="font-size:.77rem;color:var(--text-sub);">{{ $request->created_at->format('d M Y') }}</td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--text-light);">No requests yet. <a href="/Patient/Search-Hospitals" style="color:var(--secondary);">Find a hospital</a> and submit a request.</td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Requests->links() }}</div>
@endsection
