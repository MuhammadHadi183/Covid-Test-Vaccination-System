@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Book Appointment</div><div class="page-sub">Schedule a COVID test or vaccination</div></div></div>
<div class="card card-pad" style="max-width:600px;">
  <form method="POST" action="/Patient/Book-Appointment">
    @csrf
    <div class="form-group">
      <label class="form-label">Hospital</label>
      <select name="hospital_id" class="form-select" required>
        <option value="">Select Hospital</option>
        @foreach($Hospitals as $hospital)
        <option value="{{ $hospital->id }}">{{ $hospital->hospital_name }} — {{ $hospital->city }}</option>
        @endforeach
      </select>
      @if($Hospitals->isEmpty())
        <p style="margin-top:10px;font-size:.8rem;color:var(--warning);">No hospitals with a published profile yet. Try again later.</p>
      @endif
    </div>
    <div class="form-group">
      <label class="form-label">Type</label>
      <select name="type" class="form-select" required>
        <option value="covid_test">COVID-19 Test</option>
        <option value="vaccination">Vaccination</option>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Date</label>
      <input type="date" name="appointment_date" class="form-input" required min="{{ today()->toDateString() }}">
    </div>
    <div class="form-group">
      <label class="form-label">Time Slot</label>
      <select name="time_slot" class="form-select" required>
        <option value="08:00 AM">08:00 AM</option>
        <option value="09:00 AM">09:00 AM</option>
        <option value="10:00 AM">10:00 AM</option>
        <option value="11:00 AM">11:00 AM</option>
        <option value="12:00 PM">12:00 PM</option>
        <option value="01:00 PM">01:00 PM</option>
        <option value="02:00 PM">02:00 PM</option>
        <option value="03:00 PM">03:00 PM</option>
        <option value="04:00 PM">04:00 PM</option>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Notes (Optional)</label>
      <textarea name="notes" class="form-input" rows="3" placeholder="Any special requirements..."></textarea>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Book Appointment</button>
  </form>
  @if($errors->any())
  <div class="alert-box error" style="margin-top:14px;">
    @foreach($errors->all() as $errorMessage)
      <div>{{ $errorMessage }}</div>
    @endforeach
  </div>
  @endif
</div>
@endsection
