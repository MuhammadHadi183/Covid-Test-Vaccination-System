@extends('layouts.app')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Vaccination records</div>
    <div class="page-sub">Add records and update vaccination status</div>
  </div>
</div>

<div class="card card-pad mb-28" style="max-width:640px;">
  <div class="sec-title" style="margin-bottom:12px;">Add vaccination record</div>
  <p style="font-size:.78rem;color:var(--text-sub);margin-bottom:16px;">Patients listed here have either an <strong>approved request</strong> or a <strong>vaccination appointment</strong> at your hospital. Choose a vaccine with <strong>stock</strong> (quantity &gt; 0). Marking a dose as <strong>completed</strong> reduces stock by one. Completing a vaccination appointment from the Appointments page also creates a record and uses stock.</p>
  @if($errors->any())
    <div class="alert-box error" style="margin-bottom:14px;">
      @foreach($errors->all() as $errorMessage)
        <div>{{ $errorMessage }}</div>
      @endforeach
    </div>
  @endif
  <form method="POST" action="/Hospital/Vaccinations">
    @csrf
    <div class="form-group">
      <label class="form-label">Patient</label>
      <select name="patient_id" class="form-select" required>
        <option value="">Select patient</option>
        @foreach($PatientsForVax as $patient)
          <option value="{{ $patient->id }}" {{ (string) old('patient_id') === (string) $patient->id ? 'selected' : '' }}>
            {{ $patient->user->name ?? 'Patient #'.$patient->id }} @if($patient->cnic) — {{ $patient->cnic }} @endif
          </option>
        @endforeach
      </select>
      @if($PatientsForVax->isEmpty())
        <p style="margin-top:8px;font-size:.78rem;color:var(--warning);">No approved patients yet. Approve a request under Requests first.</p>
      @endif
    </div>
    <div class="form-group">
      <label class="form-label">Vaccine (in stock)</label>
      <select name="vaccine_id" class="form-select" required>
        <option value="">Select vaccine</option>
        @foreach($VaccineStocks as $stockRow)
          <option value="{{ $stockRow->vaccine_id }}" {{ (string) old('vaccine_id') === (string) $stockRow->vaccine_id ? 'selected' : '' }}>
            {{ $stockRow->vaccine->name ?? 'Vaccine #'.$stockRow->vaccine_id }} — qty {{ $stockRow->quantity }}
          </option>
        @endforeach
      </select>
      @if($VaccineStocks->isEmpty())
        <p style="margin-top:8px;font-size:.78rem;color:var(--warning);">No stock with quantity &gt; 0. Add stock under Vaccine stock.</p>
      @endif
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label class="form-label">Dose number</label>
        <input type="number" name="dose_number" class="form-input" min="1" max="10" value="{{ old('dose_number', 1) }}" required>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
          <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
          <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Notes (optional)</label>
      <textarea name="notes" class="form-input" rows="2" placeholder="Optional notes">{{ old('notes') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Add record</button>
  </form>
</div>

<div class="page-header" style="margin-bottom:16px;"><div><div class="page-title" style="font-size:1.05rem;">All records at your hospital</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Vaccine</th><th>Dose</th><th>Status</th><th>Date</th><th>Update</th></tr></thead>
  <tbody>
    @if($Vaccinations->count() > 0)
      @foreach($Vaccinations as $vaccination)
      <tr>
        <td class="td-patient"><strong>{{ $vaccination->patient->user->name ?? 'N/A' }}</strong></td>
        <td style="font-size:.79rem;">{{ $vaccination->vaccine->name ?? 'N/A' }}</td>
        <td style="font-size:.79rem;">Dose {{ $vaccination->dose_number }}</td>
        <td><span class="badge {{ $vaccination->status==='completed'?'badge-success':($vaccination->status==='cancelled'?'badge-danger':'badge-warning') }}">{{ ucfirst($vaccination->status) }}</span></td>
        <td style="font-size:.77rem;color:var(--text-sub);">{{ $vaccination->vaccinated_at ? $vaccination->vaccinated_at->format('d M Y') : 'Pending' }}</td>
        <td>
          <form method="POST" action="/Hospital/Vaccinations/{{ $vaccination->id }}/Update" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
            @csrf
            <select name="status" class="form-select" style="width:120px;padding:4px 8px;font-size:.76rem;">
              <option value="scheduled" {{ $vaccination->status==='scheduled'?'selected':'' }}>Scheduled</option>
              <option value="completed" {{ $vaccination->status==='completed'?'selected':'' }}>Completed</option>
              <option value="cancelled" {{ $vaccination->status==='cancelled'?'selected':'' }}>Cancelled</option>
            </select>
            <button class="btn btn-primary btn-sm">Save</button>
          </form>
          @if($errors->has('status'))
            <div style="font-size:.72rem;color:var(--danger);margin-top:4px;">{{ $errors->first('status') }}</div>
          @endif
        </td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--text-light);">No vaccination records</td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Vaccinations->links() }}</div>
@endsection
