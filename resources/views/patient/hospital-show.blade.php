@extends('layouts.app')
@section('content')
@php
  $hospital = $Hospital;
  $doctorsList = is_array($hospital->doctors_list) ? $hospital->doctors_list : [];
  $featuredDoctorsList = is_array($hospital->special_doctors) ? $hospital->special_doctors : [];
  $specialtiesList = is_array($hospital->specialties) ? $hospital->specialties : [];
  $facilitiesList = is_array($hospital->facilities) ? $hospital->facilities : [];
  $reviewsList = is_array($hospital->reviews) ? $hospital->reviews : [];
  $medicinesList = is_array($hospital->medicines) ? $hospital->medicines : [];
  $rating = (float) ($hospital->rating ?? 0);
  $fullStars = (int) round(min(5, max(0, $rating)));
@endphp
<style>
.hosp-hero { display: flex; flex-wrap: wrap; gap: 24px; align-items: flex-start; padding: 24px 26px; background: linear-gradient(135deg, var(--primary) 0%, #1a252f 100%); border-radius: var(--radius-lg); color: #fff; margin-bottom: 24px; }
.hosp-hero-logo { width: 88px; height: 88px; border-radius: var(--radius-md); object-fit: cover; background: rgba(255,255,255,.12); border: 2px solid rgba(255,255,255,.2); }
.hosp-hero-main { flex: 1; min-width: 200px; }
.hosp-hero h1 { font-size: 1.35rem; font-weight: 800; margin-bottom: 6px; letter-spacing: -.02em; }
.hosp-hero-stars { color: #F1C40F; font-size: 1rem; letter-spacing: 2px; margin-top: 4px; }
.info-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px; margin-bottom: 24px; }
.info-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 16px 18px; box-shadow: var(--shadow-sm); }
.info-card h4 { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-sub); margin-bottom: 10px; }
.info-card p { font-size: .86rem; color: var(--text-main); line-height: 1.45; }
.tag-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; background: #E8F4FD; color: #15527A; font-size: .74rem; font-weight: 600; margin: 4px 6px 4px 0; }
.tag-badge.fac { background: #E8F8EF; color: #1A6B3C; }
.review-item { border-bottom: 1px solid var(--border); padding: 14px 0; }
.review-item:last-child { border-bottom: none; }
.review-stars { color: #F39C12; font-size: .85rem; letter-spacing: 1px; }
</style>

<div class="page-header">
  <div>
    <div class="page-title">{{ $hospital->hospital_name }}</div>
    <div class="page-sub">Public hospital profile</div>
  </div>
  <a href="/Patient/Search-Hospitals" class="btn btn-outline">Back to search</a>
</div>

<div class="hosp-hero">
  @if($hospital->logo)
    <img src="{{ asset($hospital->logo) }}" alt="" class="hosp-hero-logo">
  @else
    <div class="hosp-hero-logo" style="display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;opacity:.5;">{{ strtoupper(substr($hospital->hospital_name, 0, 1)) }}</div>
  @endif
  <div class="hosp-hero-main">
    <h1>{{ $hospital->hospital_name }}</h1>
    <div class="hosp-hero-stars" title="{{ number_format($rating, 1) }} / 5">
      @foreach(range(1, 5) as $starIndex)
        {{ $starIndex <= $fullStars ? '★' : '☆' }}
      @endforeach
      <span style="font-size:.78rem;opacity:.9;margin-left:8px;">{{ number_format($rating, 1) }} ({{ (int)($hospital->total_reviews ?? 0) }} reviews)</span>
    </div>
    @if($hospital->vaccineStocks->count() > 0)
      <div style="margin-top:14px;font-size:.75rem;opacity:.9;">Vaccine availability:
        @foreach($hospital->vaccineStocks as $stockRow)
          <span style="margin-right:10px;">{{ $stockRow->vaccine->name ?? '' }} ({{ $stockRow->quantity }})</span>
        @endforeach
      </div>
    @endif
  </div>
</div>

<div class="info-cards">
  <div class="info-card">
    <h4>Contact</h4>
    <p><strong>Profile email</strong><br>{{ $hospital->email ?? '—' }}</p>
    <p style="margin-top:8px;"><strong>Phone</strong><br>{{ $hospital->phone ?? '—' }}</p>
    <p style="margin-top:8px;"><strong>Website</strong><br>@if($hospital->website)<a href="{{ Str::startsWith($hospital->website, ['http://','https://']) ? $hospital->website : 'https://' . $hospital->website }}" target="_blank" rel="noopener" style="color:var(--secondary);">{{ $hospital->website }}</a>@else — @endif</p>
    <p style="margin-top:8px;"><strong>City / address</strong><br>{{ $hospital->city ?? '—' }}@if($hospital->address)<br><span style="color:var(--text-sub);font-size:.8rem;">{{ $hospital->address }}</span>@endif</p>
  </div>
  <div class="info-card">
    <h4>Capacity &amp; services</h4>
    <p>Rooms: <strong>{{ (int)($hospital->total_rooms ?? 0) }}</strong></p>
    <p>Beds: <strong>{{ (int)($hospital->total_beds ?? 0) }}</strong></p>
    <p>ICU beds: <strong>{{ (int)($hospital->icu_beds ?? 0) }}</strong></p>
    <p style="margin-top:10px;">Emergency 24/7: <strong>{{ $hospital->emergency_available ? 'Yes' : 'No' }}</strong></p>
    <p>Ambulance: <strong>{{ $hospital->ambulance_available ? 'Yes' : 'No' }}</strong></p>
  </div>
  <div class="info-card">
    <h4>About</h4>
    <p>Established: <strong>{{ $hospital->established_year ?? '—' }}</strong></p>
    <p style="margin-top:8px;">Hours: <strong>{{ $hospital->operating_hours ?? '—' }}</strong></p>
    <p style="margin-top:10px;font-size:.8rem;color:var(--text-sub);">{{ $hospital->description ? Str::limit($hospital->description, 400) : 'No description.' }}</p>
  </div>
</div>

<div class="col-1-1 mb-28">
  <div class="card card-pad">
    <div class="sec-title" style="margin-bottom:12px;">Specialties</div>
    @if(count($specialtiesList) > 0)
      @foreach($specialtiesList as $specialtyName)
      <span class="tag-badge">{{ $specialtyName }}</span>
      @endforeach
    @else
      <p style="color:var(--text-light);font-size:.83rem;">None listed.</p>
    @endif
  </div>
  <div class="card card-pad">
    <div class="sec-title" style="margin-bottom:12px;">Services &amp; facilities</div>
    @if(count($facilitiesList) > 0)
      @foreach($facilitiesList as $facilityName)
      <span class="tag-badge fac">{{ $facilityName }}</span>
      @endforeach
    @else
      <p style="color:var(--text-light);font-size:.83rem;">None listed.</p>
    @endif
  </div>
</div>

<div class="card mb-28">
  <div class="card-pad" style="border-bottom:1px solid var(--border);"><span class="sec-title">Available doctors</span></div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Name</th><th>Specialty</th><th>Qualification</th><th>Phone</th></tr></thead>
      <tbody>
        @if(count($doctorsList) > 0)
          @foreach($doctorsList as $doctor)
          <tr>
            <td><strong>{{ $doctor['name'] ?? '—' }}</strong></td>
            <td>{{ $doctor['specialty'] ?? '—' }}</td>
            <td class="td-mono">{{ $doctor['qualification'] ?? '—' }}</td>
            <td>{{ $doctor['phone'] ?? '—' }}</td>
          </tr>
          @endforeach
        @else
          <tr><td colspan="4" style="text-align:center;padding:20px;color:var(--text-light);">No doctors listed.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<div class="card mb-28">
  <div class="card-pad" style="border-bottom:1px solid var(--border);"><span class="sec-title">Special / featured doctors</span></div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Name</th><th>Specialty</th><th>Qualification</th><th>Phone</th></tr></thead>
      <tbody>
        @if(count($featuredDoctorsList) > 0)
          @foreach($featuredDoctorsList as $doctor)
          <tr>
            <td><strong>{{ $doctor['name'] ?? '—' }}</strong></td>
            <td>{{ $doctor['specialty'] ?? '—' }}</td>
            <td class="td-mono">{{ $doctor['qualification'] ?? '—' }}</td>
            <td>{{ $doctor['phone'] ?? '—' }}</td>
          </tr>
          @endforeach
        @else
          <tr><td colspan="4" style="text-align:center;padding:20px;color:var(--text-light);">None listed.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<div class="card mb-28">
  <div class="card-pad" style="border-bottom:1px solid var(--border);"><span class="sec-title">Medicines &amp; pharmacy</span></div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Name</th><th>Stock</th><th>Unit</th><th>Notes</th></tr></thead>
      <tbody>
        @if(count($medicinesList) > 0)
          @foreach($medicinesList as $medicine)
          <tr>
            <td><strong>{{ $medicine['name'] ?? '—' }}</strong></td>
            <td>{{ $medicine['stock'] ?? '—' }}</td>
            <td>{{ $medicine['unit'] ?? '—' }}</td>
            <td class="td-mono">{{ $medicine['notes'] ?? '—' }}</td>
          </tr>
          @endforeach
        @else
          <tr><td colspan="4" style="text-align:center;padding:20px;color:var(--text-light);">No medicines listed.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<div class="card card-pad mb-28">
  <div class="sec-title" style="margin-bottom:16px;">Reviews</div>
  @if(count($reviewsList) > 0)
    @foreach($reviewsList as $review)
    @php
      $reviewRating = (float) ($review['rating'] ?? 0);
      $reviewFullStars = (int) round(min(5, max(0, $reviewRating)));
    @endphp
    <div class="review-item">
      <strong style="font-size:.88rem;">{{ $review['reviewer'] ?? 'Anonymous' }}</strong>
      <div class="review-stars">
        @foreach(range(1, 5) as $starIndex){{ $starIndex <= $reviewFullStars ? '★' : '☆' }}@endforeach
        <span style="color:var(--text-sub);font-size:.72rem;margin-left:6px;">{{ $review['date'] ?? '' }}</span>
      </div>
      <p style="margin-top:8px;font-size:.84rem;color:var(--text-main);line-height:1.5;">{{ $review['comment'] ?? '' }}</p>
    </div>
    @endforeach
  @else
    <p style="color:var(--text-light);font-size:.83rem;">No reviews yet.</p>
  @endif
</div>

<div class="card card-pad">
  <div class="sec-title" style="margin-bottom:14px;">Request a service</div>
  <div style="display:flex;flex-wrap:wrap;gap:10px;">
    <form method="POST" action="/Patient/Request" style="margin:0;">@csrf
      <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">
      <input type="hidden" name="request_type" value="covid_test">
      <button class="btn btn-outline">Request COVID test</button>
    </form>
    <form method="POST" action="/Patient/Request" style="margin:0;">@csrf
      <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">
      <input type="hidden" name="request_type" value="vaccination">
      <button class="btn btn-primary">Request vaccination</button>
    </form>
    <a href="/Patient/Book-Appointment" class="btn btn-outline">Book appointment</a>
  </div>
</div>
@endsection
