<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo e($PageTitle ?? 'Apex Immunity Partners'); ?> — COVID Vaccination System</title>
<link rel="icon" href="<?php echo e(asset('uploads/logo.png')); ?>">
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --primary: #2C3E50; --secondary: #3498DB; --success: #27AE60;
  --warning: #F39C12; --danger: #E74C3C; --page-bg: #F4F7F6;
  --border: #E2EAE7; --text-main: #1E3A2F; --text-sub: #5F7E72;
  --text-light: #8FA89E; --card-bg: #FFFFFF; --sidebar-w: 240px;
  --nav-h: 60px; --radius-sm: 6px; --radius-md: 10px; --radius-lg: 14px;
  --shadow-sm: 0 1px 4px rgba(44,62,80,.06); --shadow-md: 0 4px 16px rgba(44,62,80,.09);
}
body { background: var(--page-bg); color: var(--text-main); line-height: 1.55; min-height: 100vh; display: grid; grid-template-rows: var(--nav-h) 1fr; grid-template-columns: var(--sidebar-w) 1fr; grid-template-areas: "nav nav" "sidebar main"; }
.topnav { grid-area: nav; background: var(--primary); display: flex; align-items: center; padding: 0 24px; gap: 20px; position: sticky; top: 0; z-index: 200; border-bottom: 1px solid rgba(255,255,255,.08); }
.nav-brand { display: flex; align-items: center; gap: 10px; width: var(--sidebar-w); flex-shrink: 0; }
.brand-icon { width: 32px; height: 32px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; object-fit: cover; background: transparent; }
.brand-name { color: #fff; font-size: .95rem; font-weight: 700; letter-spacing: -.01em; }
.brand-name span { color: rgba(255,255,255,.55); font-weight: 400; }
.nav-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
.nav-user { display: flex; align-items: center; gap: 10px; padding: 0 6px; }
.user-av { width: 32px; height: 32px; border-radius: 50%; background: var(--secondary); display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 700; color: #fff; }
.user-info { display: flex; flex-direction: column; }
.user-name { font-size: .8rem; font-weight: 600; color: #fff; line-height: 1.1; }
.user-role { font-size: .7rem; color: rgba(255,255,255,.5); }
.nav-logout { background: rgba(255,255,255,.1); border: none; color: rgba(255,255,255,.7); padding: 6px 14px; border-radius: var(--radius-sm); cursor: pointer; font-size: .78rem; font-weight: 600; transition: all .15s; }
.nav-logout:hover { background: var(--danger); color: #fff; }
.sidebar { grid-area: sidebar; background: var(--primary); border-right: 1px solid rgba(255,255,255,.06); position: sticky; top: var(--nav-h); height: calc(100vh - var(--nav-h)); overflow-y: auto; display: flex; flex-direction: column; padding: 20px 12px; gap: 4px; }
.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }
.sidebar-label { font-size: .66rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: rgba(255,255,255,.3); padding: 14px 8px 6px; margin-top: 4px; }
.sidebar-label:first-child { margin-top: 0; padding-top: 4px; }
.nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: var(--radius-sm); color: rgba(255,255,255,.62); text-decoration: none; font-size: .84rem; font-weight: 500; transition: all .15s; cursor: pointer; }
.nav-item:hover { background: rgba(255,255,255,.07); color: rgba(255,255,255,.9); }
.nav-item.active { background: var(--secondary); color: #fff; }
.nav-item svg { flex-shrink: 0; opacity: .8; }
.nav-item.active svg { opacity: 1; }
.nav-badge { margin-left: auto; background: var(--danger); color: #fff; font-size: .67rem; font-weight: 700; padding: 1px 7px; border-radius: 10px; }
.nav-badge.orange { background: var(--warning); }
.main { grid-area: main; padding: 28px 32px 48px; overflow-x: hidden; }
.page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 28px; gap: 16px; flex-wrap: wrap; }
.page-title { font-size: 1.35rem; font-weight: 700; color: var(--primary); line-height: 1.2; }
.page-sub { font-size: .83rem; color: var(--text-sub); margin-top: 3px; }
.header-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.btn { display: inline-flex; align-items: center; gap: 7px; padding: 0 16px; height: 36px; border-radius: var(--radius-sm); font-size: .82rem; font-weight: 600; border: none; cursor: pointer; text-decoration: none; white-space: nowrap; transition: opacity .15s, transform .1s; }
.btn:hover { opacity: .88; }
.btn:active { transform: scale(.98); }
.btn-primary { background: var(--secondary); color: #fff; }
.btn-outline { background: #fff; color: var(--primary); border: 1px solid var(--border); }
.btn-success { background: var(--success); color: #fff; }
.btn-danger { background: var(--danger); color: #fff; }
.btn-sm { height: 30px; padding: 0 12px; font-size: .76rem; }
.card { background: var(--card-bg); border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }
.card-pad { padding: 20px 22px; }
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: .7rem; font-weight: 700; white-space: nowrap; }
.badge-success { background: #E8F8EF; color: #1A6B3C; }
.badge-warning { background: #FEF4DF; color: #7A4D00; }
.badge-danger { background: #FDECEC; color: #8B1C1C; }
.badge-info { background: #E8F4FD; color: #15527A; }
.badge-neutral { background: #F1F3F5; color: #4A5568; }
.hero-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: var(--border); border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 28px; box-shadow: var(--shadow-sm); }
.hero-cell { background: var(--primary); padding: 22px 24px; display: flex; flex-direction: column; gap: 6px; }
.hero-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .09em; color: rgba(255,255,255,.45); }
.hero-value { font-size: 1.9rem; font-weight: 800; color: #fff; line-height: 1; }
.hero-change { font-size: .73rem; display: flex; align-items: center; gap: 4px; }
.hero-change.up { color: #5EFFA3; }
.hero-change.down { color: #FF9090; }
.sec-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.sec-title { font-size: .85rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-sub); display: flex; align-items: center; gap: 8px; }
.sec-title::before { content: ''; display: block; width: 3px; height: 14px; background: var(--secondary); border-radius: 2px; }
.sec-link { font-size: .78rem; font-weight: 600; color: var(--secondary); text-decoration: none; }
.kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 14px; margin-bottom: 28px; }
.kpi-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px 20px; box-shadow: var(--shadow-sm); display: grid; grid-template-rows: auto 1fr auto auto; gap: 8px; transition: box-shadow .2s; }
.kpi-card:hover { box-shadow: var(--shadow-md); }
.kpi-top { display: flex; align-items: center; justify-content: space-between; }
.kpi-icon { width: 36px; height: 36px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; }
.kpi-number { font-size: 1.75rem; font-weight: 800; color: var(--primary); line-height: 1; }
.kpi-label { font-size: .73rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--text-sub); }
.kpi-foot { font-size: .74rem; color: var(--text-light); border-top: 1px solid var(--border); padding-top: 8px; margin-top: 2px; }
.col-2-3 { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
.col-1-1 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.tbl-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: .81rem; }
thead th { background: var(--page-bg); color: var(--text-sub); font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; padding: 10px 16px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap; }
tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #F7FAFA; }
tbody td { padding: 11px 16px; color: var(--text-main); vertical-align: middle; }
.td-patient strong { display: block; font-size: .82rem; font-weight: 600; color: var(--primary); }
.td-patient span { font-size: .72rem; color: var(--text-sub); }
.td-mono { font-size: .73rem; color: var(--text-light); }
.td-actions { display: flex; gap: 6px; align-items: center; }
.mb-20 { margin-bottom: 20px; }
.mb-28 { margin-bottom: 28px; }
.alert-box { padding: 14px 18px; border-radius: var(--radius-sm); margin-bottom: 16px; font-size: .83rem; font-weight: 600; }
.alert-box.success { background: #E8F8EF; color: #1A6B3C; border: 1px solid #C3E6CB; }
.alert-box.error { background: #FDECEC; color: #8B1C1C; border: 1px solid #F5C6CB; }
.form-group { margin-bottom: 18px; }
.form-label { display: block; font-size: .78rem; font-weight: 700; color: var(--text-sub); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .05em; }
.form-input { width: 100%; padding: 9px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: .84rem; color: var(--text-main); background: #fff; transition: border-color .15s; outline: none; }
.form-input:focus { border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(52,152,219,.12); }
.form-select { width: 100%; padding: 9px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: .84rem; color: var(--text-main); background: #fff; outline: none; }
.pagination-wrap { display: flex; justify-content: center; margin-top: 24px; }
.pagination-wrap nav { display: flex; gap: 4px; }
svg { display: block; }
@media (max-width: 900px) {
  :root { --sidebar-w: 0px; }
  body { grid-template-areas: "nav nav" "main main"; grid-template-columns: 1fr; }
  .sidebar { display: none; }
  .main { padding: 20px 16px 40px; }
  .hero-grid { grid-template-columns: 1fr 1fr; }
  .col-2-3, .col-1-1 { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
  .hero-grid { grid-template-columns: 1fr; }
  .kpi-grid { grid-template-columns: 1fr 1fr; }
  .user-info { display: none; }
}
</style>

</head>
<body>

<nav class="topnav">
  <a href="/Dashboard" class="nav-brand" style="text-decoration:none;">
    <img src="<?php echo e(asset('uploads/logo.png')); ?>" alt="Logo" class="brand-icon">
    <span class="brand-name">MedTrack <span>Pro</span></span>
  </a>
  <div class="nav-right">
    <div class="nav-user">
      <div class="user-av"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?></div>
      <div class="user-info">
        <span class="user-name"><?php echo e(Auth::user()->name); ?></span>
        <span class="user-role"><?php echo e(ucfirst(Auth::user()->role)); ?></span>
      </div>
    </div>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0;">
      <?php echo csrf_field(); ?>
      <button type="submit" class="nav-logout">Logout</button>
    </form>
  </div>
</nav>

<aside class="sidebar">
  <?php $Role = Auth::user()->role; ?>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Role === 'admin'): ?>
    <span class="sidebar-label">Admin Panel</span>
    <a href="/Admin/Dashboard" class="nav-item <?php echo e(request()->is('Admin/Dashboard') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a href="/Admin/Patients" class="nav-item <?php echo e(request()->is('Admin/Patients') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      All Patients
    </a>
    <a href="/Admin/Reports" class="nav-item <?php echo e(request()->is('Admin/Reports*') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      Reports
    </a>
    <a href="/Admin/Vaccines" class="nav-item <?php echo e(request()->is('Admin/Vaccines') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
      Vaccines
    </a>
    <a href="/Admin/Security/2FA" class="nav-item <?php echo e(request()->is('Admin/Security/2FA*') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      2FA Security
    </a>
    <a href="/Admin/Hospitals" class="nav-item <?php echo e(request()->is('Admin/Hospitals*') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Hospitals
    </a>
    <a href="/Admin/Bookings" class="nav-item <?php echo e(request()->is('Admin/Bookings') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Bookings
    </a>

  <?php elseif($Role === 'hospital'): ?>
    <span class="sidebar-label">Hospital Panel</span>
    <a href="/Hospital/Dashboard" class="nav-item <?php echo e(request()->is('Hospital/Dashboard') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a href="/Hospital/Patients" class="nav-item <?php echo e(request()->is('Hospital/Patients') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Patient List
    </a>
    <a href="/Hospital/Requests" class="nav-item <?php echo e(request()->is('Hospital/Requests') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Requests
    </a>
    <a href="/Hospital/Appointments" class="nav-item <?php echo e(request()->is('Hospital/Appointments*') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Appointments
    </a>
    <a href="/Hospital/Covid-Results" class="nav-item <?php echo e(request()->is('Hospital/Covid-Results*') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
      COVID Results
    </a>
    <a href="/Hospital/Vaccinations" class="nav-item <?php echo e(request()->is('Hospital/Vaccinations') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
      Vaccinations
    </a>
    <a href="/Hospital/Vaccine-Stock" class="nav-item <?php echo e(request()->is('Hospital/Vaccine-Stock*') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
      Vaccine stock
    </a>
    <a href="/Hospital/Profile" class="nav-item <?php echo e(request()->is('Hospital/Profile') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      My Profile
    </a>

  <?php elseif($Role === 'patient'): ?>
    <span class="sidebar-label">Patient Portal</span>
    <a href="/Patient/Dashboard" class="nav-item <?php echo e(request()->is('Patient/Dashboard') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a href="/Patient/Search-Hospitals" class="nav-item <?php echo e(request()->is('Patient/Search-Hospitals', 'Patient/Hospitals/*') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      Search Hospitals
    </a>
    <a href="/Patient/Book-Appointment" class="nav-item <?php echo e(request()->is('Patient/Book-Appointment') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Book Appointment
    </a>
    <a href="/Patient/Appointments" class="nav-item <?php echo e(request()->is('Patient/Appointments') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      My Appointments
    </a>
    <a href="/Patient/Requests" class="nav-item <?php echo e(request()->is('Patient/Requests') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
      My requests
    </a>
    
    <a href="/Patient/Reports" class="nav-item <?php echo e(request()->is('Patient/Reports') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
      Reports
    </a>
    <a href="/Patient/Profile" class="nav-item <?php echo e(request()->is('Patient/Profile') ? 'active' : ''); ?>">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      My Profile
    </a>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</aside>

<main class="main">
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="alert-box success"><?php echo e(session('success')); ?></div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
    <div class="alert-box error"><?php echo e(session('error')); ?></div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <?php echo $__env->yieldContent('content'); ?>
</main>

<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
<?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/layouts/app.blade.php ENDPATH**/ ?>