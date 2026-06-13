@extends('layouts.app')
@section('content')
  <div class="page-header">
    <div>
      <div class="page-title">Search Hospitals</div>
      <div class="page-sub">Find COVID test or vaccination hospitals</div>
    </div>
  </div>
  <div class="card card-pad mb-20">
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <input type="text" class="form-input" placeholder="Hospital name..." id="HospitalName" value=""
        style="max-width:300px;">
      <input type="text" class="form-input" placeholder="City..." id="HospitalCity" value=""
        style="max-width:200px;">
    </div>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;" id="HospitalCardGrid">
    <div class="card card-pad" style="text-align:center;color:var(--text-light);">Loading hospitals...</div>
  </div>
  <div id="pagination-wrap" class="pagination-wrap" style="margin-top:24px;"></div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    function RenderHospitals(hospitals) {
      $('#HospitalCardGrid').html("");
      
      if (!hospitals || hospitals.length === 0) {
        $('#HospitalCardGrid').html('<div class="card card-pad" style="text-align:center;color:var(--text-light);">No hospitals found</div>');
        $('#pagination-wrap').html("");
        return;
      }

      hospitals.forEach(function (Data) {
        let ratingHtml = '';
        if (Data.rating && parseFloat(Data.rating) > 0) {
          ratingHtml = `<div style="font-size:.8rem;color:#F39C12;margin-bottom:8px;">${parseFloat(Data.rating).toFixed(1)} / 5 · ${Data.total_reviews || 0} reviews</div>`;
        }

        let shortAddress = Data.address ? (Data.address.length > 80 ? Data.address.substring(0, 80) + '...' : Data.address) : '';
        let phone = Data.phone || 'N/A';

        $('#HospitalCardGrid').append(`
          <div class="card card-pad">
            <div style="font-size:1rem;font-weight:700;color:var(--primary);margin-bottom:4px;">${Data.hospital_name}</div>
            <div style="font-size:.78rem;color:var(--text-sub);margin-bottom:8px;">${Data.city} · ${phone}</div>
            ${ratingHtml}
            <div style="font-size:.76rem;color:var(--text-light);margin-bottom:14px;">${shortAddress}</div>
            <div style="margin-bottom:12px;">
              <a href="/Patient/Hospitals/${Data.id}" class="btn btn-outline btn-sm">View profile</a>
            </div>
            <div style="display:flex;gap:8px;">
              <form method="POST" action="/Patient/Request" style="margin:0;">
                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                <input type="hidden" name="hospital_id" value="${Data.id}">
                <input type="hidden" name="request_type" value="covid_test">
                <button class="btn btn-outline btn-sm">Request Test</button>
              </form>
              <form method="POST" action="/Patient/Request" style="margin:0;">
                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                <input type="hidden" name="hospital_id" value="${Data.id}">
                <input type="hidden" name="request_type" value="vaccination">
                <button class="btn btn-primary btn-sm">Request Vaccine</button>
              </form>
            </div>
          </div>
        `);
      });
      $('#pagination-wrap').html("");
    }

    function FetchRecords() {
      let InputName = $('#HospitalName').val().trim();
      let InputCity = $('#HospitalCity').val().trim();

      $.ajax({
        url: "/Filter",
        type: "GET",
        data: {
          DataName: InputName,
          DataCity: InputCity
        },
        success: function (response) {
          RenderHospitals(response);
        },
        error: function() {
          $('#HospitalCardGrid').html('<div class="card card-pad" style="text-align:center;color:var(--text-light);">Error loading hospitals</div>');
        }
      });
    }

    // Search on input
    $('#HospitalName').on('input', FetchRecords);
    $('#HospitalCity').on('input', FetchRecords);

    // Load all hospitals on page load
    $(document).ready(function() {
      FetchRecords();
    });
  </script>
@endsection