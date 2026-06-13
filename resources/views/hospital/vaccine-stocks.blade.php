@extends('layouts.app')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Vaccine inventory</div>
    <div class="page-sub">Define vaccines for your hospital, then add quantities. Global vaccines from the admin appear together with your own.</div>
  </div>
</div>

@if($errors->any())
<div class="card card-pad mb-20" style="max-width:560px;">
  <div class="alert-box error">
    @foreach($errors->all() as $errorMessage)
      <div>{{ $errorMessage }}</div>
    @endforeach
  </div>
</div>
@endif

<div class="card card-pad mb-28" style="max-width:560px;">
  <div class="sec-title" style="margin-bottom:12px;">Add vaccine (your catalog)</div>
  <p style="font-size:.78rem;color:var(--text-sub);margin-bottom:16px;">Use this when your vaccine is not listed below. After saving, add stock in the next section.</p>
  <form method="POST" action="/Hospital/Vaccine-Catalog">
    @csrf
    <div class="form-group">
      <label class="form-label">Vaccine name</label>
      <input type="text" name="name" class="form-input" value="{{ old('name') }}" required maxlength="255" placeholder="e.g. COVID-19 mRNA (booster)">
    </div>
    <div class="form-group">
      <label class="form-label">Manufacturer</label>
      <input type="text" name="manufacturer" class="form-input" value="{{ old('manufacturer') }}" required maxlength="255">
    </div>
    <div class="form-group">
      <label class="form-label">Doses required (course)</label>
      <input type="number" name="doses_required" class="form-input" min="1" max="10" value="{{ old('doses_required', 2) }}" required>
    </div>
    <div class="form-group">
      <label class="form-label">Description (optional)</label>
      <textarea name="description" class="form-input" rows="2" placeholder="Notes for your staff">{{ old('description') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Save vaccine</button>
  </form>
</div>

<div class="card card-pad mb-28" style="max-width:560px;">
  <div class="sec-title" style="margin-bottom:12px;">Add stock</div>
  <p style="font-size:.78rem;color:var(--text-sub);margin-bottom:16px;">Pick a vaccine from the <strong>combined catalog</strong> (admin + yours). If you already have a row for it here, the quantity is increased.</p>
  <form method="POST" action="/Hospital/Vaccine-Stock">
    @csrf
    <div class="form-group">
      <label class="form-label">Vaccine</label>
      <select name="vaccine_id" class="form-select" required>
        <option value="">Select vaccine</option>
        @foreach($Vaccines as $vaccine)
          <option value="{{ $vaccine->id }}">{{ $vaccine->name }} — {{ $vaccine->manufacturer }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Quantity to add</label>
      <input type="number" name="quantity" class="form-input" min="1" value="50" required>
    </div>
    <div class="form-group">
      <label class="form-label">Expiry date (optional)</label>
      <input type="date" name="expiry_date" class="form-input">
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Add stock</button>
  </form>
</div>

<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Vaccine</th><th>Manufacturer</th><th>Stock &amp; expiry</th><th style="width:100px;">Delete</th></tr></thead>
  <tbody>
    @if($Stocks->count() > 0)
      @foreach($Stocks as $stockRow)
      <tr>
        <td><strong>{{ $stockRow->vaccine->name ?? '—' }}</strong></td>
        <td style="font-size:.79rem;">{{ $stockRow->vaccine->manufacturer ?? '—' }}</td>
        <td>
          <form method="POST" action="/Hospital/Vaccine-Stock/{{ $stockRow->id }}/Update" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            @csrf
            <label style="font-size:.72rem;color:var(--text-sub);">Qty</label>
            <input type="number" name="quantity" class="form-input" min="0" value="{{ $stockRow->quantity }}" style="width:88px;padding:6px 10px;font-size:.8rem;" required>
            <label style="font-size:.72rem;color:var(--text-sub);">Expiry</label>
            <input type="date" name="expiry_date" class="form-input" value="{{ $stockRow->expiry_date ? $stockRow->expiry_date->format('Y-m-d') : '' }}" style="width:150px;padding:6px 10px;font-size:.8rem;">
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
          </form>
          <div style="font-size:.68rem;color:var(--text-light);margin-top:6px;">Set quantity to <strong>0</strong> and save to remove this line.</div>
        </td>
        <td>
          <form method="POST" action="/Hospital/Vaccine-Stock/{{ $stockRow->id }}/Delete" style="margin:0;" onsubmit="return confirm('Delete this stock row?')">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="4" style="text-align:center;padding:24px;color:var(--text-light);">No stock yet — use the form above.</td></tr>
    @endif
  </tbody>
</table></div></div>
@endsection
