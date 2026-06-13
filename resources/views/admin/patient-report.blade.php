<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Report — {{ $Patient->user->name ?? 'None' }}</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',Tahoma,sans-serif;background:#f0f2f5;color:#1a1a2e;line-height:1.5}
.report{max-width:900px;margin:30px auto;background:#fff;border-radius:12px;box-shadow:0 4px 30px rgba(0,0,0,.08);overflow:hidden}
.report-header{background:linear-gradient(135deg,#2C3E50 0%,#34495E 100%);padding:40px 48px;color:#fff;display:flex;justify-content:space-between;align-items:flex-start}
.report-brand{display:flex;align-items:center;gap:12px;font-size:1.1rem;font-weight:700}
.report-brand-icon{width:40px;height:40px;background:#3498DB;border-radius:10px;display:flex;align-items:center;justify-content:center}
.report-date{font-size:.82rem;color:rgba(255,255,255,.6);margin-top:6px}
.report-title{text-align:right}
.report-title h1{font-size:1.4rem;font-weight:800;margin-bottom:4px}
.report-title p{font-size:.8rem;color:rgba(255,255,255,.55)}

.report-body{padding:40px 48px}

.patient-info{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:36px;padding:24px;background:#f8fafb;border-radius:10px;border:1px solid #e8ecef}
.info-item{display:flex;flex-direction:column;gap:2px}
.info-label{font-size:.68rem;text-transform:uppercase;letter-spacing:.08em;color:#8a9bae;font-weight:700}
.info-value{font-size:.92rem;font-weight:600;color:#1a1a2e}

.section{margin-bottom:32px}
.section-title{font-size:.9rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#2C3E50;margin-bottom:14px;padding-bottom:8px;border-bottom:2px solid #3498DB;display:inline-block}

table{width:100%;border-collapse:collapse;font-size:.82rem}
thead{background:#f4f6f8}
th{text-align:left;padding:10px 14px;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#6b7c93;border-bottom:2px solid #e8ecef}
td{padding:10px 14px;border-bottom:1px solid #f0f2f5}
tr:hover{background:#fafbfc}

.badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;text-transform:uppercase}
.badge-positive,.badge-danger{background:#fde8e8;color:#c0392b}
.badge-negative,.badge-success{background:#e8f8f0;color:#27ae60}
.badge-pending,.badge-warning{background:#fef5e7;color:#f39c12}
.badge-completed{background:#e8f8f0;color:#27ae60}
.badge-scheduled{background:#eaf2fb;color:#2980b9}

.summary-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:32px}
.summary-card{background:#f8fafb;border:1px solid #e8ecef;border-radius:10px;padding:18px;text-align:center}
.summary-num{font-size:1.8rem;font-weight:800;color:#2C3E50;line-height:1}
.summary-label{font-size:.68rem;color:#8a9bae;text-transform:uppercase;letter-spacing:.06em;margin-top:4px}

.empty-msg{text-align:center;padding:24px;color:#a0aec0;font-size:.85rem}

.report-footer{padding:20px 48px;border-top:1px solid #e8ecef;display:flex;justify-content:space-between;align-items:center;font-size:.76rem;color:#a0aec0}

.no-print{padding:20px 0;text-align:center}
.print-btn{display:inline-flex;align-items:center;gap:8px;padding:12px 32px;background:#3498DB;color:#fff;border:none;border-radius:8px;font-size:.88rem;font-weight:600;cursor:pointer;transition:all .2s}
.print-btn:hover{background:#2980b9;transform:translateY(-1px)}
.back-btn{display:inline-flex;align-items:center;gap:8px;padding:12px 32px;background:#95a5a6;color:#fff;border:none;border-radius:8px;font-size:.88rem;font-weight:600;cursor:pointer;text-decoration:none;margin-right:12px}
.back-btn:hover{background:#7f8c8d}

@media print{
  body{background:#fff}
  .report{box-shadow:none;margin:0;border-radius:0}
  .no-print{display:none!important}
  .report-header{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  .summary-card,.patient-info{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  .badge{-webkit-print-color-adjust:exact;print-color-adjust:exact}
}
</style>
</head>
<body>

<div class="no-print" style="max-width:900px;margin:0 auto;">
  <a href="/Admin/Reports" class="back-btn">← Back to Reports</a>

</div>

<div class="report">
  <div class="report-header">
    <div>
      <div class="report-brand">
        <img src="{{ asset('uploads/logo.png') }}" alt="Logo" class="report-brand-icon" style="object-fit:cover;background:transparent;border-radius:0;">
        Apex Immunity Partners
      </div>
      <div class="report-date">Generated on {{ now()->format('d M Y — h:i A') }}</div>
    </div>
    <div class="report-title">
      <h1>Patient Report</h1>
      <p>COVID-19 Test & Vaccination Record</p>
    </div>
  </div>

  <div class="report-body">
    <div class="patient-info">
      <div class="info-item"><span class="info-label">Full Name</span><span class="info-value">{{ $Patient->user->name ?? 'None' }}</span></div>
      <div class="info-item"><span class="info-label">Email</span><span class="info-value">{{ $Patient->user->email ?? 'None' }}</span></div>
      <div class="info-item"><span class="info-label">CNIC</span><span class="info-value">{{ $Patient->cnic ?? 'None' }}</span></div>
      <div class="info-item"><span class="info-label">Phone</span><span class="info-value">{{ $Patient->user->phone ?? 'None' }}</span></div>
      <div class="info-item"><span class="info-label">Gender</span><span class="info-value">{{ ucfirst($Patient->gender ?? 'None') }}</span></div>
      <div class="info-item"><span class="info-label">Blood Group</span><span class="info-value">{{ $Patient->blood_group ?? 'None' }}</span></div>
      <div class="info-item"><span class="info-label">City</span><span class="info-value">{{ $Patient->city ?? 'None' }}</span></div>
      <div class="info-item"><span class="info-label">Registered</span><span class="info-value">{{ $Patient->created_at->format('d M Y') }}</span></div>
    </div>

    <div class="summary-row">
      <div class="summary-card"><div class="summary-num">{{ $Tests->count() }}</div><div class="summary-label">Total Tests</div></div>
      <div class="summary-card"><div class="summary-num">{{ $Tests->where('result','positive')->count() }}</div><div class="summary-label">Positive</div></div>
      <div class="summary-card"><div class="summary-num">{{ $Vaccinations->count() }}</div><div class="summary-label">Vaccinations</div></div>
      <div class="summary-card"><div class="summary-num">{{ $Appointments->count() }}</div><div class="summary-label">Appointments</div></div>
    </div>

    <div class="section">
      <div class="section-title">COVID-19 Test Results</div>
      <table>
        <thead><tr><th>#</th><th>Test Type</th><th>Result</th><th>CT Value</th><th>Hospital</th><th>Date</th></tr></thead>
        <tbody>
          @if($Tests->count() > 0)
            @foreach($Tests as $Index => $Test)
            <tr>
              <td>{{ $Index + 1 }}</td>
              <td>{{ $Test->test_type }}</td>
              <td>
                @if($Test->result === 'positive')<span class="badge badge-positive">Positive</span>
                @elseif($Test->result === 'negative')<span class="badge badge-negative">Negative</span>
                @else<span class="badge badge-pending">Pending</span>@endif
              </td>
              <td>{{ $Test->ct_value ?? 'None' }}</td>
              <td>{{ $Test->hospital->hospital_name ?? 'None' }}</td>
              <td>{{ $Test->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
          @else
            <tr><td colspan="6" class="empty-msg">No COVID tests recorded</td></tr>
          @endif
        </tbody>
      </table>
    </div>

    <div class="section">
      <div class="section-title">Vaccination Records</div>
      <table>
        <thead><tr><th>#</th><th>Vaccine</th><th>Dose</th><th>Status</th><th>Hospital</th><th>Date</th></tr></thead>
        <tbody>
          @if($Vaccinations->count() > 0)
            @foreach($Vaccinations as $Index => $Vaccination)
            <tr>
              <td>{{ $Index + 1 }}</td>
              <td>{{ $Vaccination->vaccine->name ?? 'None' }}</td>
              <td>Dose {{ $Vaccination->dose_number }}</td>
              <td><span class="badge badge-{{ $Vaccination->status === 'completed' ? 'completed' : ($Vaccination->status === 'cancelled' ? 'danger' : 'scheduled') }}">{{ ucfirst($Vaccination->status) }}</span></td>
              <td>{{ $Vaccination->hospital->hospital_name ?? 'None' }}</td>
              <td>{{ $Vaccination->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
          @else
            <tr><td colspan="6" class="empty-msg">No vaccinations recorded</td></tr>
          @endif
        </tbody>
      </table>
    </div>

    <div class="section">
      <div class="section-title">Appointment History</div>
      <table>
        <thead><tr><th>#</th><th>Hospital</th><th>Type</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
        <tbody>
          @if($Appointments->count() > 0)
            @foreach($Appointments as $Index => $Appointment)
            <tr>
              <td>{{ $Index + 1 }}</td>
              <td>{{ $Appointment->hospital->hospital_name ?? 'None' }}</td>
              <td>{{ $Appointment->type === 'covid_test' ? 'COVID Test' : 'Vaccination' }}</td>
              <td>{{ $Appointment->appointment_date->format('d M Y') }}</td>
              <td>{{ $Appointment->time_slot ?? 'None' }}</td>
              <td><span class="badge badge-{{ $Appointment->status === 'completed' ? 'completed' : ($Appointment->status === 'cancelled' ? 'danger' : 'scheduled') }}">{{ ucfirst($Appointment->status) }}</span></td>
            </tr>
            @endforeach
          @else
            <tr><td colspan="6" class="empty-msg">No appointments recorded</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>

  <div class="report-footer">
    <span>Apex Immunity Partners — COVID-19 Vaccination Management System</span>
    <span>Report ID: RPT-{{ str_pad($Patient->id, 5, '0', STR_PAD_LEFT) }}-{{ now()->format('Ymd') }}</span>
  </div>
</div>

</body>
</html>
