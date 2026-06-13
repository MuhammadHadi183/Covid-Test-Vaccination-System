@extends('layouts.app')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">COVID-19 test results</div>
    <div class="page-sub">Add new tests and update results for your hospital</div>
  </div>
</div>

<div class="card card-pad mb-28" style="max-width:640px;">
  <div class="sec-title" style="margin-bottom:12px;">Add COVID test result</div>
  <p style="font-size:.78rem;color:var(--text-sub);margin-bottom:16px;">Only patients with an <strong>approved request</strong> at your hospital can be selected.</p>
  @if($errors->any())
    <div class="alert-box error" style="margin-bottom:14px;">
      @foreach($errors->all() as $errorMessage)
        <div>{{ $errorMessage }}</div>
      @endforeach
    </div>
  @endif
  <form method="POST" action="/Hospital/Covid-Results">
    @csrf
    <div class="form-group">
      <label class="form-label">Patient</label>
      <select name="patient_id" class="form-select" required>
        <option value="">Select patient</option>
        @foreach($Patients as $patient)
          <option value="{{ $patient->id }}" {{ (string) old('patient_id') === (string) $patient->id ? 'selected' : '' }}>
            {{ $patient->user->name ?? 'Patient #'.$patient->id }} @if($patient->cnic) — {{ $patient->cnic }} @endif
          </option>
        @endforeach
      </select>
      @if($Patients->isEmpty())
        <p style="margin-top:8px;font-size:.78rem;color:var(--warning);">No approved patients yet. Approve a request under Requests first.</p>
      @endif
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label class="form-label">Test type</label>
        <select name="test_type" class="form-select" required>
          <option value="PCR" {{ old('test_type') === 'PCR' ? 'selected' : '' }}>PCR</option>
          <option value="Antigen RAT" {{ old('test_type') === 'Antigen RAT' ? 'selected' : '' }}>Antigen RAT</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Result</label>
        <select name="result" class="form-select">
          <option value="pending" {{ old('result', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="negative" {{ old('result') === 'negative' ? 'selected' : '' }}>Negative</option>
          <option value="positive" {{ old('result') === 'positive' ? 'selected' : '' }}>Positive</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">CT value (optional)</label>
      <input type="number" step="0.01" name="ct_value" class="form-input" value="{{ old('ct_value') }}" placeholder="e.g. 18.5">
    </div>
    <div class="form-group">
      <label class="form-label">Notes (optional)</label>
      <textarea name="notes" class="form-input" rows="2" placeholder="Internal notes">{{ old('notes') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Add test record</button>
  </form>
</div>

<div class="page-header" style="margin-bottom:16px;"><div><div class="page-title" style="font-size:1.05rem;">All tests at your hospital</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Type</th><th>Result</th><th>CT</th><th>Notes</th><th>Date</th><th>Update</th></tr></thead>
  <tbody>
    @if($Tests->count() > 0)
      @foreach($Tests as $test)
      <tr>
        <td class="td-patient"><strong>{{ $test->patient->user->name ?? 'N/A' }}</strong></td>
        <td style="font-size:.79rem;">{{ $test->test_type }}</td>
        <td><span class="badge {{ $test->result==='positive'?'badge-danger':($test->result==='negative'?'badge-success':'badge-warning') }}">{{ ucfirst($test->result) }}</span></td>
        <td style="font-size:.82rem;">{{ $test->ct_value ?? '—' }}</td>
        <td style="font-size:.72rem;color:var(--text-sub);max-width:140px;">{{ Str::limit($test->notes ?? '—', 40) }}</td>
        <td style="font-size:.77rem;color:var(--text-sub);">{{ $test->created_at->format('d M Y') }}</td>
        <td>
          <form method="POST" action="/Hospital/Covid-Results/{{ $test->id }}/Update" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
            @csrf
            <select name="result" class="form-select" style="width:110px;padding:4px 8px;font-size:.76rem;">
              <option value="pending" {{ $test->result==='pending'?'selected':'' }}>Pending</option>
              <option value="positive" {{ $test->result==='positive'?'selected':'' }}>Positive</option>
              <option value="negative" {{ $test->result==='negative'?'selected':'' }}>Negative</option>
            </select>
            <input type="number" step="0.01" name="ct_value" placeholder="CT" value="{{ $test->ct_value }}" class="form-input" style="width:70px;padding:4px 8px;font-size:.76rem;">
            <button class="btn btn-primary btn-sm">Save</button>
          </form>
        </td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text-light);">No test records yet</td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Tests->links() }}</div>
@endsection
