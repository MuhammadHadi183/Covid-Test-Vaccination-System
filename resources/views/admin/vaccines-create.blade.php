@extends('layouts.app')
@section('content')
<div class="page-header"><div><div class="page-title">Add Vaccine</div></div></div>
<div class="card card-pad" style="max-width:500px;">
  <form method="POST" action="/Admin/Vaccines/Store">@csrf
    <div class="form-group"><label class="form-label">Vaccine Name</label><input type="text" name="name" class="form-input" required></div>
    <div class="form-group"><label class="form-label">Manufacturer</label><input type="text" name="manufacturer" class="form-input" required></div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group"><label class="form-label">Doses Required</label><input type="number" name="doses_required" class="form-input" value="2" min="1" required></div>
      <div class="form-group"><label class="form-label">Status</label><input type="text" class="form-input" value="Auto (based on stock)" readonly style="background:#f5f5f5;"></div>
    </div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="3"></textarea></div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Add Vaccine</button>
  </form>
  @if($errors->any())<div class="alert-box error" style="margin-top:14px;">@foreach($errors->all() as $E)<div>{{ $E }}</div>@endforeach</div>@endif
</div>
@endsection
