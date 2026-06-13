@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Edit Vaccine — {{ $Vaccine->name }}</div><div class="page-sub">Catalog details and hospital inventory</div></div>
  <a href="/Admin/Vaccines" class="btn btn-outline">Back to vaccines</a>
</div>
<div class="card card-pad mb-20" style="max-width:560px;">
  <form method="POST" action="/Admin/Vaccines/{{ $Vaccine->id }}/Update">@csrf
    <div class="form-group"><label class="form-label">Vaccine Name</label><input type="text" name="name" class="form-input" value="{{ $Vaccine->name }}" required></div>
    <div class="form-group"><label class="form-label">Manufacturer</label><input type="text" name="manufacturer" class="form-input" value="{{ $Vaccine->manufacturer }}" required></div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group"><label class="form-label">Doses required (per patient)</label><input type="number" name="doses_required" class="form-input" value="{{ $Vaccine->doses_required }}" min="1" required></div>
      <div class="form-group"><label class="form-label">Status</label><input type="text" class="form-input" value="{{ $Vaccine->status === 'available' ? 'Available' : 'Unavailable' }}
      " readonly style="background:#f5f5f5;"></div>
    </div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="3">{{ $Vaccine->description }}</textarea></div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Update Vaccine</button>
  </form>
</div>

<div class="card card-pad" style="max-width:560px;">
  <div class="sec-title" style="margin-bottom:14px;">Hospital stock</div>
  <p style="font-size:.8rem;color:var(--text-sub);margin-bottom:16px;line-height:1.5;">Stock is stored <strong>per hospital</strong>, not on this form. Use the section below to <strong>add doses</strong> to a hospital. Total stock across all hospitals sets the vaccine status above.</p>
  @if($Vaccine->stocks->count() > 0)
    <div class="tbl-wrap mb-20">
      <table>
        <thead><tr><th>Hospital</th><th>Quantity</th><th>Expiry</th></tr></thead>
        <tbody>
          @foreach($Vaccine->stocks as $S)
          <tr>
            <td>{{ $S->hospital->hospital_name ?? '—' }}</td>
            <td><strong>{{ $S->quantity }}</strong></td>
            <td class="td-mono">{{ $S->expiry_date ? $S->expiry_date->format('Y-m-d') : '—' }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <p style="font-size:.83rem;color:var(--text-light);margin-bottom:16px;">No stock rows yet — add stock using the form below.</p>
  @endif

  <div class="sec-title" style="margin-bottom:12px;">Add stock</div>
  <form method="POST" action="/Admin/Vaccines/{{ $Vaccine->id }}/Stock">@csrf
    <div class="form-group">
      <label class="form-label">Hospital</label>
      <select name="hospital_id" class="form-select" required>
        <option value="">Select hospital</option>
        @foreach($Hospitals as $H)
          <option value="{{ $H->id }}">{{ $H->hospital_name }} — {{ $H->city }}</option>
        @endforeach
      </select>
      @if($Hospitals->isEmpty())
        <p style="margin-top:8px;font-size:.78rem;color:var(--warning);">No approved hospitals yet. Approve a hospital first, then add stock.</p>
      @endif
    </div>
    <div class="form-group">
      <label class="form-label">Quantity to add</label>
      <input type="number" name="quantity" class="form-input" min="1" value="100" required>
    </div>
    <div class="form-group">
      <label class="form-label">Expiry date (optional)</label>
      <input type="date" name="expiry_date" class="form-input">
    </div>
    <button type="submit" class="btn btn-success" style="width:100%;justify-content:center;height:42px;">Add stock</button>
  </form>
</div>
@endsection
