@extends('layouts.app')
@section('content')
  <div class="page-header">
    <div>
      <div class="page-title">Edit Patient — {{ $Patient->user->name }}</div>
    </div>
  </div>
  <div class="card card-pad" style="max-width:600px;">
    <form method="POST" action="/Admin/Patients/{{ $Patient->id }}/Update">@csrf
      <div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" class="form-input"
          value="{{ $Patient->user->name }}" required></div>
      <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-input"
          value="{{ $Patient->user->email }}" readonly style="background:#f5f5f5;"></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group"><label class="form-label">Phone</label><input type="text" name="phone" class="form-input"
            value="{{ $Patient->user->phone }}"></div>
        <div class="form-group"><label class="form-label">Gender</label><select name="gender" class="form-select">
            <option value="" selected disabled>Select</option>
            <option value="male" {{ $Patient->gender === 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ $Patient->gender === 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ $Patient->gender === 'other' ? 'selected' : '' }}>Other</option>
          </select></div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group"><label class="form-label">CNIC</label><input type="text" name="cnic" class="form-input"
            value="{{ $Patient->cnic }}"></div>
        <div class="form-group"><label class="form-label">Blood Group</label><select name="blood_group"
            class="form-select">
            <option value="" selected disabled>Select</option>
            <option value="A+" {{ $Patient->blood_group === 'A+' ? 'selected' : '' }}>A+</option>
            <option value="A-" {{ $Patient->blood_group === 'A-' ? 'selected' : '' }}>A-</option>
            <option value="B+" {{ $Patient->blood_group === 'B+' ? 'selected' : '' }}>B+</option>
            <option value="B-" {{ $Patient->blood_group === 'B-' ? 'selected' : '' }}>B-</option>
            <option value="AB+" {{ $Patient->blood_group === 'AB+' ? 'selected' : '' }}>AB+</option>
            <option value="AB-" {{ $Patient->blood_group === 'AB-' ? 'selected' : '' }}>AB-</option>
            <option value="O+" {{ $Patient->blood_group === 'O+' ? 'selected' : '' }}>O+</option>
            <option value="O-" {{ $Patient->blood_group === 'O-' ? 'selected' : '' }}>O-</option>
          </select></div>
      </div>
      <div class="form-group"><label class="form-label">City</label><input type="text" name="city" class="form-input"
          value="{{ $Patient->city }}"></div>
      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Update
        Patient</button>
    </form>
    @if($errors->any())
    </div>@endif
  </div>
@endsection