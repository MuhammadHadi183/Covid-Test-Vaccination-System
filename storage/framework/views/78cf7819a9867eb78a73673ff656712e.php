<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">Hospital Dashboard</div><div class="page-sub"><?php echo e($Hospital->hospital_name); ?> — <?php echo e(now()->format('l, d F Y')); ?></div></div></div>
<div class="hero-grid mb-28">
  <div class="hero-cell"><span class="hero-label">Approved Patients</span><span class="hero-value"><?php echo e($TotalPatients); ?></span></div>
  <div class="hero-cell"><span class="hero-label">Pending Requests</span><span class="hero-value"><?php echo e($PendingRequests); ?></span></div>
  <div class="hero-cell"><span class="hero-label">Today's Tests</span><span class="hero-value"><?php echo e($TodayTests); ?></span></div>
  <div class="hero-cell"><span class="hero-label">Vaccinations Done</span><span class="hero-value"><?php echo e($TotalVaccinations); ?></span></div>
</div>
<div class="col-1-1 mb-28">
  <div>
    <div class="sec-head"><span class="sec-title">Pending Requests</span></div>
    <div class="card">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($RecentRequests->count() > 0): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $RecentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $R): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid var(--border);">
          <div style="flex:1;"><div style="font-size:.83rem;font-weight:600;color:var(--primary);"><?php echo e($R->patient?->user?->name ?? 'N/A'); ?></div><div style="font-size:.73rem;color:var(--text-sub);"><?php echo e($R->request_type === 'covid_test' ? 'COVID Test' : 'Vaccination'); ?> · <?php echo e($R->created_at->format('d M')); ?></div></div>
          <div class="td-actions">
            <form method="POST" action="/Hospital/Requests/<?php echo e($R->id); ?>/Approve" style="margin:0;"><?php echo csrf_field(); ?><button class="btn btn-success btn-sm">Approve</button></form>
            <form method="POST" action="/Hospital/Requests/<?php echo e($R->id); ?>/Reject" style="margin:0;"><?php echo csrf_field(); ?><button class="btn btn-danger btn-sm">Reject</button></form>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      <?php else: ?>
        <div style="text-align:center;padding:24px;color:var(--text-light);">No pending requests</div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
  <div>
    <div class="sec-head"><span class="sec-title">Vaccine Stock</span></div>
    <div class="card card-pad">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Stocks->count() > 0): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $S): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
          <div><div style="font-size:.84rem;font-weight:600;"><?php echo e($S->vaccine->name ?? 'N/A'); ?></div><div style="font-size:.72rem;color:var(--text-sub);">Exp: <?php echo e($S->expiry_date ? $S->expiry_date->format('M Y') : 'N/A'); ?></div></div>
          <div style="font-size:1.1rem;font-weight:800;color:<?php echo e($S->quantity < 100 ? 'var(--danger)' : 'var(--success)'); ?>;"><?php echo e($S->quantity); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      <?php else: ?>
        <div style="text-align:center;color:var(--text-light);">No stock data</div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</div>
<div class="mb-28">
  <div class="sec-head">
    <span class="sec-title">Today's Appointments</span>
    <a href="/Hospital/Appointments" class="sec-link">View all</a>
  </div>
  <div class="card"><div class="tbl-wrap"><table>
    <thead><tr><th>Patient</th><th>Time</th><th>Type</th><th>Status</th></tr></thead>
    <tbody>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($TodayAppointments->count() > 0): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $TodayAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $A): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td class="td-patient"><strong><?php echo e($A->patient?->user?->name ?? 'N/A'); ?></strong></td>
          <td style="font-size:.82rem;font-weight:700;"><?php echo e($A->time_slot ?? 'N/A'); ?></td>
          <td style="font-size:.79rem;"><?php echo e($A->type === 'covid_test' ? 'COVID Test' : 'Vaccination'); ?></td>
          <td><span class="badge <?php echo e($A->status==='completed'?'badge-success':($A->status==='confirmed'?'badge-info':'badge-warning')); ?>"><?php echo e(ucfirst($A->status)); ?></span></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      <?php else: ?>
        <tr><td colspan="4" style="text-align:center;padding:24px;color:var(--text-light);">No appointments today</td></tr>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </tbody>
  </table></div></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/hospital/dashboard.blade.php ENDPATH**/ ?>