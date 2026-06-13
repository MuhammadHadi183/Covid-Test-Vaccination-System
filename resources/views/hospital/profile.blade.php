@extends('layouts.app')
@section('content')
@php
  $Doctors = $Hospital->doctors_list ?? [];
  $SpecialDoctors = $Hospital->special_doctors ?? [];
  $Specialties = $Hospital->specialties ?? [];
  $Facilities = $Hospital->facilities ?? [];
  $Reviews = $Hospital->reviews ?? [];
  $Medicines = $Hospital->medicines ?? [];
@endphp
<style>
.profile-grid { display: grid; gap: 20px; }
@media (min-width: 900px) { .profile-grid.cols-2 { grid-template-columns: 1fr 1fr; } }
.profile-section { background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px 22px; box-shadow: var(--shadow-sm); }
.profile-section h3 { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-sub); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.profile-section h3::before { content: ''; width: 3px; height: 14px; background: var(--secondary); border-radius: 2px; }
.tag-wrap { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
.tag-chip { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; background: #E8F4FD; color: #15527A; font-size: .76rem; font-weight: 600; }
.tag-chip button { border: none; background: transparent; color: inherit; cursor: pointer; padding: 0 2px; font-size: 1rem; line-height: 1; opacity: .6; }
.tag-chip button:hover { opacity: 1; }
.dyn-table { width: 100%; font-size: .8rem; border-collapse: collapse; }
.dyn-table th { text-align: left; padding: 8px 6px; color: var(--text-sub); font-size: .68rem; text-transform: uppercase; }
.dyn-table td { padding: 6px; }
.dyn-table input { width: 100%; padding: 7px 10px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: .8rem; }
.logo-preview { width: 100px; height: 100px; border-radius: var(--radius-md); object-fit: cover; border: 1px solid var(--border); background: var(--page-bg); }
.review-card { border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 12px 14px; margin-bottom: 10px; }
.review-meta { font-size: .72rem; color: var(--text-sub); margin-top: 4px; }
.stars-inline { color: #F39C12; letter-spacing: 1px; font-size: .85rem; }
</style>

<div class="page-header">
  <div>
    <div class="page-title">Hospital profile</div>
    <div class="page-sub">Manage public details, capacity, staff, and reviews shown on your record</div>
  </div>
  <div class="header-actions">
    <form method="POST" action="/Hospital/Profile/Delete" style="margin:0;" onsubmit="return confirm('Reset all extended profile data? Core registration fields stay unchanged.')">
      @csrf
      <button type="submit" class="btn btn-outline">Reset profile data</button>
    </form>
  </div>
</div>

<form method="POST" action="/Hospital/Profile" enctype="multipart/form-data" id="hospital-profile-form" onsubmit="syncHospitalProfileJson(); return true;">
  @csrf
  <input type="hidden" name="doctors_json" id="doctors_json" value="">
  <input type="hidden" name="special_doctors_json" id="special_doctors_json" value="">
  <input type="hidden" name="specialties_json" id="specialties_json" value="">
  <input type="hidden" name="facilities_json" id="facilities_json" value="">
  <input type="hidden" name="reviews_json" id="reviews_json" value="">
  <input type="hidden" name="medicines_json" id="medicines_json" value="">

  <div class="profile-grid mb-28">
    <div class="profile-section" style="grid-column: 1 / -1;">
      <h3>Basic information</h3>
      <div class="profile-grid cols-2">
        <div class="form-group">
          <label class="form-label">Hospital name</label>
          <input type="text" name="hospital_name" class="form-input" value="{{ old('hospital_name', $Hospital->hospital_name) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Logo</label>
          @if($Hospital->logo)
            <div style="margin-bottom:8px;"><img src="{{ asset($Hospital->logo) }}" alt="Logo" class="logo-preview" id="logo-preview"></div>
          @else
            <div style="margin-bottom:8px;"><img src="" alt="" class="logo-preview" id="logo-preview" style="display:none;"></div>
          @endif
          <input type="file" name="logo" class="form-input" accept="image/jpeg,image/png,image/webp" id="logo-input">
        </div>
        <div class="form-group">
          <label class="form-label">Profile email</label>
          <input type="email" name="email" class="form-input" value="{{ old('email', $Hospital->email) }}" placeholder="contact@hospital.org">
        </div>
        <div class="form-group">
          <label class="form-label">Website</label>
          <input type="text" name="website" class="form-input" value="{{ old('website', $Hospital->website) }}" placeholder="https://example.com">
        </div>
        <div class="form-group">
          <label class="form-label">Established year</label>
          <input type="number" name="established_year" class="form-input" value="{{ old('established_year', $Hospital->established_year) }}" min="1800" max="{{ date('Y') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Operating hours</label>
          <input type="text" name="operating_hours" class="form-input" value="{{ old('operating_hours', $Hospital->operating_hours) }}" placeholder="e.g. 24/7 or 8:00 AM – 10:00 PM">
        </div>
        <div class="form-group" style="grid-column: 1 / -1;">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-input" value="{{ old('address', $Hospital->address) }}">
        </div>
        <div class="form-group">
          <label class="form-label">City</label>
          <input type="text" name="city" class="form-input" value="{{ old('city', $Hospital->city) }}">
        </div>
        <div class="form-group">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-input" value="{{ old('phone', $Hospital->phone) }}">
        </div>
        <div class="form-group" style="grid-column: 1 / -1;">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-input" rows="3">{{ old('description', $Hospital->description) }}</textarea>
        </div>
      </div>
    </div>

    <div class="profile-section">
      <h3>Capacity &amp; services</h3>
      <div class="form-group">
        <label class="form-label">Total rooms</label>
        <input type="number" name="total_rooms" class="form-input" min="0" value="{{ old('total_rooms', $Hospital->total_rooms ?? 0) }}">
      </div>
      <div class="form-group">
        <label class="form-label">Total beds</label>
        <input type="number" name="total_beds" class="form-input" min="0" value="{{ old('total_beds', $Hospital->total_beds ?? 0) }}">
      </div>
      <div class="form-group">
        <label class="form-label">ICU beds</label>
        <input type="number" name="icu_beds" class="form-input" min="0" value="{{ old('icu_beds', $Hospital->icu_beds ?? 0) }}">
      </div>
      <div class="form-group" style="display:flex;gap:20px;flex-wrap:wrap;">
        <label style="display:flex;align-items:center;gap:8px;font-size:.84rem;cursor:pointer;">
          <input type="checkbox" name="emergency_available" value="1" {{ old('emergency_available', $Hospital->emergency_available) ? 'checked' : '' }}>
          24/7 emergency
        </label>
        <label style="display:flex;align-items:center;gap:8px;font-size:.84rem;cursor:pointer;">
          <input type="checkbox" name="ambulance_available" value="1" {{ old('ambulance_available', $Hospital->ambulance_available) ? 'checked' : '' }}>
          Ambulance service
        </label>
      </div>
    </div>

    <div class="profile-section">
      <h3>Specialties &amp; facilities</h3>
      <div class="form-group">
        <label class="form-label">Add specialty (press Enter)</label>
        <input type="text" class="form-input" id="specialty-input" placeholder="e.g. Cardiology" autocomplete="off">
        <div class="tag-wrap" id="specialty-tags"></div>
      </div>
      <div class="form-group">
        <label class="form-label">Add facility (press Enter)</label>
        <input type="text" class="form-input" id="facility-input" placeholder="e.g. Laboratory" autocomplete="off">
        <div class="tag-wrap" id="facility-tags"></div>
      </div>
    </div>

    <div class="profile-section" style="grid-column: 1 / -1;">
      <h3>Doctors list</h3>
      <div style="overflow-x:auto;">
        <table class="dyn-table" id="doctors-table">
          <thead><tr><th>Name</th><th>Specialty</th><th>Qualification</th><th>Phone</th><th style="width:44px;"></th></tr></thead>
          <tbody id="doctors-tbody"></tbody>
        </table>
      </div>
      <button type="button" class="btn btn-outline btn-sm" style="margin-top:10px;" onclick="addDoctorRow()">Add doctor</button>
    </div>

    <div class="profile-section" style="grid-column: 1 / -1;">
      <h3>Featured / special doctors</h3>
      <div style="overflow-x:auto;">
        <table class="dyn-table" id="special-doctors-table">
          <thead><tr><th>Name</th><th>Specialty</th><th>Qualification</th><th>Phone</th><th style="width:44px;"></th></tr></thead>
          <tbody id="special-doctors-tbody"></tbody>
        </table>
      </div>
      <button type="button" class="btn btn-outline btn-sm" style="margin-top:10px;" onclick="addSpecialDoctorRow()">Add featured doctor</button>
    </div>

    <div class="profile-section" style="grid-column: 1 / -1;">
      <h3>Medicines &amp; pharmacy stock</h3>
      <p style="font-size:.78rem;color:var(--text-sub);margin-bottom:12px;">List medicines or pharmacy items patients should know about.</p>
      <div style="overflow-x:auto;">
        <table class="dyn-table" id="medicines-table">
          <thead><tr><th>Name</th><th>Stock / qty</th><th>Unit</th><th>Notes</th><th style="width:44px;"></th></tr></thead>
          <tbody id="medicines-tbody"></tbody>
        </table>
      </div>
      <button type="button" class="btn btn-outline btn-sm" style="margin-top:10px;" onclick="addMedicineRow()">Add medicine</button>
    </div>

    <div class="profile-section" style="grid-column: 1 / -1;">
      <h3>Reviews &amp; rating</h3>
      <p style="font-size:.83rem;color:var(--text-sub);margin-bottom:12px;">
        Average rating: <strong id="rating-preview">{{ number_format((float)($Hospital->rating ?? 0), 1) }}</strong> / 5 ·
        <span id="reviews-count-preview">{{ (int)($Hospital->total_reviews ?? 0) }}</span> reviews
      </p>
      <div id="reviews-list"></div>
      <div style="border-top:1px solid var(--border);padding-top:16px;margin-top:8px;">
        <div class="profile-grid cols-2">
          <div class="form-group">
            <label class="form-label">Reviewer name</label>
            <input type="text" class="form-input" id="new-review-reviewer" placeholder="Patient or reviewer name">
          </div>
          <div class="form-group">
            <label class="form-label">Rating (1–5)</label>
            <select class="form-select" id="new-review-rating">
              @foreach(range(5,1,-1) as $R)
                <option value="{{ $R }}">{{ $R }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Comment</label>
          <textarea class="form-input" rows="2" id="new-review-comment" placeholder="Review text"></textarea>
        </div>
        <button type="button" class="btn btn-outline btn-sm" onclick="appendReview()">Add review to list</button>
      </div>
    </div>
  </div>

  <div class="card card-pad" style="max-width:420px;">
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Save profile</button>
  </div>
</form>

@if($errors->any())
<div class="card card-pad mt-20" style="margin-top:20px;border-color:#F5C6CB;">
  <div class="alert-box error" style="margin:0;">
    @foreach($errors->all() as $E)<div>{{ $E }}</div>@endforeach
  </div>
</div>
@endif

<script>
(function () {
  let specialties = @json($Specialties);
  let facilities = @json($Facilities);
  let reviews = @json($Reviews);

  const doctorsTbody = document.getElementById('doctors-tbody');
  const specialDoctorsTbody = document.getElementById('special-doctors-tbody');
  const medicinesTbody = document.getElementById('medicines-tbody');
  const specialtyTags = document.getElementById('specialty-tags');
  const facilityTags = document.getElementById('facility-tags');

  function esc(s) {
    const d = document.createElement('div');
    d.textContent = s == null ? '' : String(s);
    return d.innerHTML;
  }
  function attr(s) {
    return String(s ?? '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');
  }

  function renderTags(container, arr, type) {
    container.innerHTML = arr.map((t, i) =>
      '<span class="tag-chip">' + esc(t) +
      '<button type="button" aria-label="Remove" onclick="removeTag(\'' + type + '\',' + i + ')">&times;</button></span>'
    ).join('');
  }
  window.removeTag = function (type, index) {
    if (type === 'specialty') { specialties.splice(index, 1); renderTags(specialtyTags, specialties, 'specialty'); }
    else { facilities.splice(index, 1); renderTags(facilityTags, facilities, 'facility'); }
  };

  document.getElementById('specialty-input').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); const v = this.value.trim(); if (v && !specialties.includes(v)) { specialties.push(v); renderTags(specialtyTags, specialties, 'specialty'); } this.value = ''; }
  });
  document.getElementById('facility-input').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); const v = this.value.trim(); if (v && !facilities.includes(v)) { facilities.push(v); renderTags(facilityTags, facilities, 'facility'); } this.value = ''; }
  });

  function medicineRow(m) {
    const tr = document.createElement('tr');
    tr.innerHTML = '<td><input type="text" class="med-name" value="' + attr(m.name) + '"></td>' +
      '<td><input type="text" class="med-stock" value="' + attr(m.stock) + '"></td>' +
      '<td><input type="text" class="med-unit" value="' + attr(m.unit) + '"></td>' +
      '<td><input type="text" class="med-notes" value="' + attr(m.notes) + '"></td>' +
      '<td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest(\'tr\').remove()">×</button></td>';
    return tr;
  }
  window.addMedicineRow = function () { medicinesTbody.appendChild(medicineRow({ name: '', stock: '', unit: '', notes: '' })); };

  @json($Medicines).forEach(function (m) {
    medicinesTbody.appendChild(medicineRow({ name: m.name || '', stock: m.stock != null ? String(m.stock) : '', unit: m.unit || '', notes: m.notes || '' }));
  });
  if (!medicinesTbody.children.length) { addMedicineRow(); }

  function collectMedicines(tbody) {
    const out = [];
    tbody.querySelectorAll('tr').forEach(function (tr) {
      const name = tr.querySelector('.med-name')?.value.trim() || '';
      const stock = tr.querySelector('.med-stock')?.value.trim() || '';
      const unit = tr.querySelector('.med-unit')?.value.trim() || '';
      const notes = tr.querySelector('.med-notes')?.value.trim() || '';
      if (name || stock || unit || notes) {
        out.push({ name: name, stock: stock, unit: unit, notes: notes });
      }
    });
    return out;
  }

  function doctorRow(d) {
    const tr = document.createElement('tr');
    tr.innerHTML = '<td><input type="text" class="doc-name" value="' + attr(d.name) + '"></td>' +
      '<td><input type="text" class="doc-spec" value="' + attr(d.specialty) + '"></td>' +
      '<td><input type="text" class="doc-qual" value="' + attr(d.qualification) + '"></td>' +
      '<td><input type="text" class="doc-phone" value="' + attr(d.phone) + '"></td>' +
      '<td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest(\'tr\').remove()">×</button></td>';
    return tr;
  }
  window.addDoctorRow = function () { doctorsTbody.appendChild(doctorRow({ name: '', specialty: '', qualification: '', phone: '' })); };
  window.addSpecialDoctorRow = function () { specialDoctorsTbody.appendChild(doctorRow({ name: '', specialty: '', qualification: '', phone: '' })); };

  @json($Doctors).forEach(function (d) { doctorsTbody.appendChild(doctorRow({ name: d.name || '', specialty: d.specialty || '', qualification: d.qualification || '', phone: d.phone || '' })); });
  @json($SpecialDoctors).forEach(function (d) { specialDoctorsTbody.appendChild(doctorRow({ name: d.name || '', specialty: d.specialty || '', qualification: d.qualification || '', phone: d.phone || '' })); });
  if (!doctorsTbody.children.length) addDoctorRow();
  if (!specialDoctorsTbody.children.length) addSpecialDoctorRow();

  renderTags(specialtyTags, specialties, 'specialty');
  renderTags(facilityTags, facilities, 'facility');

  function collectDoctors(tbody) {
    const out = [];
    tbody.querySelectorAll('tr').forEach(function (tr) {
      const name = tr.querySelector('.doc-name')?.value.trim() || '';
      const specialty = tr.querySelector('.doc-spec')?.value.trim() || '';
      const qualification = tr.querySelector('.doc-qual')?.value.trim() || '';
      const phone = tr.querySelector('.doc-phone')?.value.trim() || '';
      if (name || specialty || qualification || phone) {
        out.push({ name: name, specialty: specialty, qualification: qualification, phone: phone });
      }
    });
    return out;
  }

  function updateRatingPreview() {
    let sum = 0, n = 0;
    reviews.forEach(function (r) {
      const x = parseFloat(r.rating);
      if (!isNaN(x) && x > 0) { sum += x; n++; }
    });
    const avg = n ? (Math.round((sum / n) * 10) / 10).toFixed(1) : '0.0';
    document.getElementById('rating-preview').textContent = avg;
    document.getElementById('reviews-count-preview').textContent = String(reviews.length);
  }

  function renderReviews() {
    const el = document.getElementById('reviews-list');
    el.innerHTML = reviews.map(function (r, i) {
      const stars = '★'.repeat(Math.min(5, Math.max(0, Math.round(parseFloat(r.rating) || 0)))) + '☆'.repeat(5 - Math.min(5, Math.max(0, Math.round(parseFloat(r.rating) || 0))));
      return '<div class="review-card"><div style="display:flex;justify-content:space-between;gap:10px;align-items:flex-start;">' +
        '<div><strong style="font-size:.86rem;">' + esc(r.reviewer) + '</strong><div class="stars-inline">' + stars + '</div>' +
        '<div style="font-size:.83rem;margin-top:8px;">' + esc(r.comment) + '</div><div class="review-meta">' + esc(r.date || '') + '</div></div>' +
        '<button type="button" class="btn btn-danger btn-sm" onclick="removeReview(' + i + ')">Remove</button></div></div>';
    }).join('') || '<p style="color:var(--text-light);font-size:.83rem;">No reviews yet.</p>';
    updateRatingPreview();
  }
  window.removeReview = function (i) { reviews.splice(i, 1); renderReviews(); };
  window.appendReview = function () {
    const reviewer = document.getElementById('new-review-reviewer').value.trim();
    const rating = document.getElementById('new-review-rating').value;
    const comment = document.getElementById('new-review-comment').value.trim();
    if (!reviewer || !comment) { alert('Please enter reviewer name and comment.'); return; }
    const d = new Date();
    const dateStr = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
    reviews.push({ reviewer: reviewer, rating: parseInt(rating, 10), comment: comment, date: dateStr });
    document.getElementById('new-review-reviewer').value = '';
    document.getElementById('new-review-comment').value = '';
    renderReviews();
  };

  renderReviews();

  window.syncHospitalProfileJson = function () {
    document.getElementById('doctors_json').value = JSON.stringify(collectDoctors(doctorsTbody));
    document.getElementById('special_doctors_json').value = JSON.stringify(collectDoctors(specialDoctorsTbody));
    document.getElementById('specialties_json').value = JSON.stringify(specialties);
    document.getElementById('facilities_json').value = JSON.stringify(facilities);
    document.getElementById('reviews_json').value = JSON.stringify(reviews);
    document.getElementById('medicines_json').value = JSON.stringify(collectMedicines(medicinesTbody));
  };

  const logoInput = document.getElementById('logo-input');
  const logoPreview = document.getElementById('logo-preview');
  if (logoInput && logoPreview) {
    logoInput.addEventListener('change', function () {
      const f = this.files && this.files[0];
      if (!f) return;
      logoPreview.style.display = 'block';
      logoPreview.src = URL.createObjectURL(f);
    });
  }
})();
</script>
@endsection
