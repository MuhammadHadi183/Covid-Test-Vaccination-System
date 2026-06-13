@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Vaccine Inventory</div><div class="page-sub">Manage available / unavailable vaccines</div></div>
<div class="header-actions"><a href="/Admin/Vaccines/Create" class="btn btn-primary">+ Add Vaccine</a></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Vaccine</th><th>Manufacturer</th><th>Doses</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    @if($Vaccines->count() > 0)
      @foreach($Vaccines as $V)
      <tr>
        <td class="td-patient"><strong>{{ $V->name }}</strong><span>{{ $V->description ?? '' }}</span></td>
        <td style="font-size:.79rem;">{{ $V->manufacturer }}</td>
        <td style="font-size:.79rem;">{{ $V->doses_required }}</td>
        <td style="font-size:.82rem;font-weight:700;">{{ number_format($V->total_stock ?? 0) }}</td>
        <td><span class="badge {{ $V->status==='available'?'badge-success':'badge-danger' }}">{{ ucfirst($V->status) }}</span></td>
        <td><div class="td-actions">
          <a href="/Admin/Vaccines/{{ $V->id }}/Edit" class="btn btn-outline btn-sm">Edit</a>
          <form method="POST" action="/Admin/Vaccines/{{ $V->id }}/Delete" style="margin:0;" onsubmit="return confirm('Delete this vaccine?')">@csrf <button class="btn btn-danger btn-sm">Del</button></form>
        </div></td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--text-light);">No vaccines added</td></tr>
    @endif
  </tbody>
</table></div></div>
@endsection
