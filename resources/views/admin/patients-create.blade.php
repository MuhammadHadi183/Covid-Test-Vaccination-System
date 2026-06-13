@extends('layouts.app')
@section('content')
  <div class="page-header">
    <div>
      <div class="page-title">Add New Patient</div>
    </div>
  </div>
  <div class="card card-pad" style="max-width:600px;">
    <form method="POST" action="/Admin/Patients/Store">
      @csrf
      <div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" class="form-input"
          required></div>
      <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-input"
          required></div>
      <div class="form-group"><label class="form-label">Password</label><input type="password" name="password"
          class="form-input" required></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group"><label class="form-label">Phone</label><input type="text" name="phone" class="form-input">
        </div>
        <div class="form-group"><label class="form-label">Gender</label><select name="gender" class="form-select">
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select></div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div class="form-group"><label class="form-label">CNIC</label><input type="text" name="cnic" class="form-input">
        </div>
        <div class="form-group"><label class="form-label">Blood Group</label><select name="blood_group"
            class="form-select">
            <option value="" selected disabled>Select</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
          </select></div>
      </div>
      <div class="form-group"><label class="form-label">City</label><input type="text" name="city" class="form-input">
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Create
        Patient</button>
    </form>

  </div>
@endsection