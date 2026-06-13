@extends('layouts.app')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Patient appointments</div>
    <div class="page-sub">Bookings at your hospital — confirm, complete, or cancel. Completing a <strong>vaccination</strong> visit records the dose and uses one unit of stock.</div>
  </div>
</div>
@if($errors->any())
<div class="card card-pad mb-20">
  <div class="alert-box error">
    @foreach($errors->all() as $errorMessage)
      <div>{{ $errorMessage }}</div>
    @endforeach
  </div>
</div>
@endif
@if(isset($VaccineStocksForAppt) && $VaccineStocksForAppt->isEmpty())
<div class="card card-pad mb-20">
  <div class="alert-box error" style="background:rgba(180,80,0,.12);border-color:rgba(180,80,0,.35);color:var(--text);">
    You have no vaccine stock (quantity: 0). Add stock under <a href="/Hospital/Vaccine-Stock" style="color:var(--secondary);font-weight:600;">Vaccine stock</a> before you can complete vaccination appointments.
  </div>
</div>
@endif
<div class="card card-pad mb-20">
  <div style="display:flex;flex-wrap:wrap;gap:8px;">
    <a href="/Hospital/Appointments" class="btn {{ ($Status ?? 'all') === 'all' ? 'btn-primary' : 'btn-outline' }} btn-sm">All</a>
    <a href="/Hospital/Appointments?status=pending" class="btn {{ ($Status ?? '') === 'pending' ? 'btn-primary' : 'btn-outline' }} btn-sm">Pending</a>
    <a href="/Hospital/Appointments?status=confirmed" class="btn {{ ($Status ?? '') === 'confirmed' ? 'btn-primary' : 'btn-outline' }} btn-sm">Confirmed</a>
    <a href="/Hospital/Appointments?status=completed" class="btn {{ ($Status ?? '') === 'completed' ? 'btn-primary' : 'btn-outline' }} btn-sm">Completed</a>
    <a href="/Hospital/Appointments?status=cancelled" class="btn {{ ($Status ?? '') === 'cancelled' ? 'btn-primary' : 'btn-outline' }} btn-sm">Cancelled</a>
  </div>
</div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Type</th><th>Date</th><th>Time</th><th>Doctor</th><th>Notes</th><th>Status</th><th>Cancel reason</th><th>Actions</th></tr></thead>
  <tbody>
    @if($Appointments->count() > 0)
      @foreach($Appointments as $appointment)
      <tr>
        <td class="td-patient"><strong>{{ $appointment->patient?->user?->name ?? 'N/A' }}</strong></td>
        <td style="font-size:.79rem;">{{ $appointment->type === 'covid_test' ? 'COVID test' : 'Vaccination' }}</td>
        <td style="font-size:.79rem;">{{ $appointment->appointment_date?->format('d M Y') ?? '—' }}</td>
        <td style="font-size:.79rem;">{{ $appointment->time_slot ?? '—' }}</td>
        <td style="font-size:.79rem;color:var(--primary);font-weight:600;">{{ $appointment->doctor_name ?? '—' }}</td>
        <td style="font-size:.72rem;color:var(--text-sub);max-width:160px;">{{ Str::limit($appointment->notes ?? '—', 48) }}</td>
        <td><span class="badge {{ $appointment->status==='completed'?'badge-success':($appointment->status==='cancelled'?'badge-danger':($appointment->status==='confirmed'?'badge-info':'badge-warning')) }}">{{ ucfirst($appointment->status) }}</span></td>
        <td style="font-size:.72rem;color:var(--text-sub);max-width:140px;">{{ $appointment->status === 'cancelled' ? Str::limit($appointment->cancel_reason ?? '—', 80) : '—' }}</td>
        <td>
          <form method="POST" action="/Hospital/Appointments/{{ $appointment->id }}/Status" data-appointment-type="{{ $appointment->type }}" style="display:flex;gap:6px;align-items:flex-start;flex-wrap:wrap;margin:0;max-width:320px;">
            @csrf
            <div style="display:flex;flex-direction:column;gap:6px;flex:1;min-width:160px;">
              <select name="status" class="form-select appt-status" style="width:100%;padding:4px 8px;font-size:.76rem;">
                <option value="pending" {{ $appointment->status==='pending'?'selected':'' }}>Pending</option>
                <option value="confirmed" {{ $appointment->status==='confirmed'?'selected':'' }}>Confirmed</option>
                <option value="completed" {{ $appointment->status==='completed'?'selected':'' }}>Completed</option>
                <option value="cancelled" {{ $appointment->status==='cancelled'?'selected':'' }}>Cancelled</option>
              </select>
              <textarea name="cancel_reason" class="form-input appt-cancel-reason" rows="2" style="font-size:.72rem;padding:6px 8px;display:none;" placeholder="Reason for cancellation (required)">{{ old('cancel_reason', $appointment->cancel_reason) }}</textarea>
              <div class="appt-doctor-wrap" style="display:none;">
                <select name="doctor_name" class="form-select" style="width:100%;padding:4px 8px;font-size:.74rem;">
                  <option value="">Select Doctor (required)…</option>
                  @if(is_array($Hospital->doctors_list))
                    @foreach($Hospital->doctors_list as $doc)
                      @php $docName = is_array($doc) ? ($doc['name'] ?? 'Doctor') : (is_object($doc) ? ($doc->name ?? 'Doctor') : $doc); @endphp
                      <option value="{{ $docName }}" {{ $appointment->doctor_name === $docName ? 'selected' : '' }}>
                        {{ $docName }}
                      </option>
                    @endforeach
                  @endif
                </select>
              </div>
              @if($appointment->type === 'vaccination')
              <div class="appt-vax-wrap" style="display:none;">
                <label class="form-label" style="font-size:.72rem;margin-bottom:4px;">Vaccine given</label>
                <select name="vaccine_id" class="form-select" style="width:100%;padding:4px 8px;font-size:.74rem;">
                  <option value="">Select vaccine…</option>
                  @foreach($VaccineStocksForAppt ?? [] as $stockRow)
                    <option value="{{ $stockRow->vaccine_id }}" {{ $appointment->vaccinationRecord && (string) $appointment->vaccinationRecord->vaccine_id === (string) $stockRow->vaccine_id ? 'selected' : '' }}>
                      {{ $stockRow->vaccine->name ?? 'Vaccine' }} ({{ $stockRow->quantity }})
                    </option>
                  @endforeach
                </select>
                <label class="form-label" style="font-size:.72rem;margin:8px 0 4px;">Dose number</label>
                <input type="number" name="dose_number" class="form-input" min="1" max="10" value="{{ $appointment->vaccinationRecord?->dose_number ?? 1 }}" style="padding:6px 8px;font-size:.76rem;">
                @if($appointment->vaccinationRecord)
                  <p style="margin:6px 0 0;font-size:.68rem;color:var(--text-sub);">Dose already on file for this visit.</p>
                @endif
              </div>
              @endif
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-start;">Save</button>
          </form>
        </td>
      </tr>
      @endforeach
    @else
      <tr><td colspan="8" style="text-align:center;padding:24px;color:var(--text-light);">No appointments</td></tr>
    @endif
  </tbody>
</table></div></div>
<div class="pagination-wrap">{{ $Appointments->links() }}</div>
<script>

document.querySelectorAll('form[action*="/Hospital/Appointments/"][action$="/Status"]').forEach(function (form) {
  var statusSelect = form.querySelector('.appt-status');
  var cancelTextarea = form.querySelector('.appt-cancel-reason');
  var doctorBox = form.querySelector('.appt-doctor-wrap');
  var vaccineBox = form.querySelector('.appt-vax-wrap');
  var appointmentType = form.getAttribute('data-appointment-type');

  function updateExtraFields() {
    if (!statusSelect) {
      return;
    }
    var status = statusSelect.value;

    if (cancelTextarea) {
      var showCancel = status === 'cancelled';
      cancelTextarea.style.display = showCancel ? 'block' : 'none';
      if (!showCancel) {
        cancelTextarea.value = '';
      }
    }

    if (doctorBox) {
      var showDoctor = status === 'confirmed' || status === 'completed';
      doctorBox.style.display = showDoctor ? 'block' : 'none';
    }

    if (vaccineBox && appointmentType === 'vaccination') {
      var showVaccine = status === 'completed';
      vaccineBox.style.display = showVaccine ? 'block' : 'none';
      if (!showVaccine) {
        var vaccineSelect = vaccineBox.querySelector('select[name="vaccine_id"]');
        var doseInput = vaccineBox.querySelector('input[name="dose_number"]');
        if (vaccineSelect) {
          vaccineSelect.selectedIndex = 0;
        }
        if (doseInput) {
          doseInput.value = '1';
        }
      }
    }
  }

  if (statusSelect) {
    statusSelect.addEventListener('change', updateExtraFields);
    updateExtraFields();
  }
});
</script>
@endsection
