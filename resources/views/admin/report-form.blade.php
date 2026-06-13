@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Generate Report</div><div class="page-sub">Fill in the details for {{ $Patient->user->name ?? 'Patient' }}</div></div>
<div class="header-actions"><a href="/Admin/Reports" class="btn btn-outline">← Back</a></div></div>

<div class="card card-pad mb-28" style="background:linear-gradient(135deg,#eaf2f8,#d5e8d4);border-left:4px solid var(--primary-color);">
  <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:16px;">
    <div><span style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#8a9bae;font-weight:700;">Patient Name</span><div style="font-size:.92rem;font-weight:600;">{{ $Patient->user->name ?? 'N/A' }}</div></div>
    <div><span style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#8a9bae;font-weight:700;">Email</span><div style="font-size:.92rem;font-weight:600;">{{ $Patient->user->email ?? 'N/A' }}</div></div>
    <div><span style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#8a9bae;font-weight:700;">CNIC</span><div style="font-size:.92rem;font-weight:600;">{{ $Patient->cnic ?? 'N/A' }}</div></div>
    <div><span style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#8a9bae;font-weight:700;">City</span><div style="font-size:.92rem;font-weight:600;">{{ $Patient->city ?? 'N/A' }}</div></div>
  </div>
</div>

<form method="POST" action="/Admin/Reports/Generate/{{ $Patient->id }}">
  @csrf
  <input type="hidden" name="patient_id" value="{{ $Patient->id }}">

  <div class="card card-pad mb-28">
    <div class="sec-head" style="margin-bottom:16px;"><span class="sec-title">Report Type</span></div>
    <div class="form-group">
      <label class="form-label">What to generate?</label>
      <select name="report_type" id="report_type" class="form-select" style="max-width:300px;" required onchange="toggleSections()">
        <option value="">— Select —</option>
        <option value="covid_test">COVID Test Report</option>
        <option value="vaccination">Vaccination Report</option>
        <option value="full">Full Report (Test + Vaccination)</option>
      </select>
    </div>
  </div>

  <div id="covid_section" class="card card-pad mb-28" style="display:none;">
    <div class="sec-head" style="margin-bottom:16px;"><span class="sec-title">COVID Test Details</span></div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="form-group">
        <label class="form-label">Test Type</label>
        <select name="test_type" class="form-select">
          <option value="">— Select —</option>
          <option value="PCR">PCR</option>
          <option value="Antigen RAT">Antigen RAT</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Hospital</label>
        <select name="covid_hospital_id" class="form-select">
          <option value="">— Select Hospital —</option>
          @foreach($Hospitals as $H)
            <option value="{{ $H->id }}">{{ $H->hospital_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Result</label>
        <select name="result" class="form-select">
          <option value="pending">Pending</option>
          <option value="positive">Positive</option>
          <option value="negative">Negative</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">CT Value (optional)</label>
        <input type="number" step="0.01" name="ct_value" class="form-input" placeholder="e.g. 18.40">
      </div>
    </div>
  </div>

  <div id="vaccination_section" class="card card-pad mb-28" style="display:none;">
    <div class="sec-head" style="margin-bottom:16px;"><span class="sec-title">Vaccination Details</span></div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="form-group">
        <label class="form-label">Vaccine</label>
        <select name="vaccine_id" class="form-select">
          <option value="">— Select Vaccine —</option>
          @php $Vaccines = \App\Models\Vaccine::where('status','available')->get(); @endphp
          @foreach($Vaccines as $V)
            <option value="{{ $V->id }}">{{ $V->name }} ({{ $V->manufacturer }})</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Hospital</label>
        <select name="vaccine_hospital_id" class="form-select">
          <option value="">— Select Hospital —</option>
          @foreach($Hospitals as $H)
            <option value="{{ $H->id }}">{{ $H->hospital_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Dose Number</label>
        <select name="dose_number" class="form-select">
          <option value="1">Dose 1</option>
          <option value="2">Dose 2</option>
          <option value="3">Booster</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="vaccination_status" class="form-select">
          <option value="scheduled">Scheduled</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>
    </div>
  </div>

  <div class="card card-pad mb-28">
    <div class="form-group">
      <label class="form-label">Notes (optional)</label>
      <textarea name="notes" class="form-input" rows="3" placeholder="Any additional notes for this report..."></textarea>
    </div>
  </div>

  <button type="submit" class="btn btn-primary" style="width:100%;max-width:400px;justify-content:center;height:44px;font-size:.9rem;">Generate Report</button>

  @if($errors->any())
  <div class="alert-box error" style="margin-top:14px;">@foreach($errors->all() as $E)<div>{{ $E }}</div>@endforeach</div>
  @endif
</form>

<script>
function toggleSections() {
  var Type = document.getElementById('report_type').value;
  document.getElementById('covid_section').style.display = (Type === 'covid_test' || Type === 'full') ? 'block' : 'none';
  document.getElementById('vaccination_section').style.display = (Type === 'vaccination' || Type === 'full') ? 'block' : 'none';
}
</script>
@endsection
