<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">Hospital management</div><div class="page-sub">Directory (completed profiles), pending approvals, or full list</div></div></div>
<div class="card card-pad mb-20">
  <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:12px;">
    <span style="font-size:.72rem;font-weight:700;color:var(--text-sub);text-transform:uppercase;margin-right:6px;">View</span>
    <a href="<?php echo e(url('/Admin/Hospitals?tab=directory')); ?>" class="btn <?php echo e(($Tab ?? 'directory') === 'directory' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Published profiles</a>
    <a href="<?php echo e(url('/Admin/Hospitals?tab=pending')); ?>" class="btn <?php echo e(($Tab ?? '') === 'pending' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Pending approval</a>
    <a href="<?php echo e(url('/Admin/Hospitals?tab=all')); ?>" class="btn <?php echo e(($Tab ?? '') === 'all' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">All records</a>
  </div>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($Tab ?? 'directory') === 'all'): ?>
  <div style="display:flex;gap:8px;flex-wrap:wrap;">
    <a href="<?php echo e(url('/Admin/Hospitals?tab=all')); ?>" class="btn <?php echo e(($Status ?? 'all') === 'all' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">All statuses</a>
    <a href="<?php echo e(url('/Admin/Hospitals?tab=all&status=pending')); ?>" class="btn <?php echo e(($Status ?? '') === 'pending' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Pending</a>
    <a href="<?php echo e(url('/Admin/Hospitals?tab=all&status=approved')); ?>" class="btn <?php echo e(($Status ?? '') === 'approved' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Approved</a>
    <a href="<?php echo e(url('/Admin/Hospitals?tab=all&status=rejected')); ?>" class="btn <?php echo e(($Status ?? '') === 'rejected' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Rejected</a>
  </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Hospital</th><th>City</th><th>Phone</th><th>Registration</th><th>Status</th><th>Profile</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Hospitals->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Hospitals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $H): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($H->hospital_name); ?></strong><span><?php echo e($H->user->email ?? ''); ?></span></td>
        <td style="font-size:.79rem;"><?php echo e($H->city); ?></td>
        <td style="font-size:.79rem;"><?php echo e($H->phone ?? 'N/A'); ?></td>
        <td class="td-mono"><?php echo e($H->registration_no ?? 'N/A'); ?></td>
        <td><span class="badge <?php echo e($H->status==='approved'?'badge-success':($H->status==='rejected'?'badge-danger':'badge-warning')); ?>"><?php echo e(ucfirst($H->status)); ?></span></td>
        <td><span class="badge <?php echo e($H->profile_completed ? 'badge-info' : 'badge-neutral'); ?>"><?php echo e($H->profile_completed ? 'Yes' : 'No'); ?></span></td>
        <td><div class="td-actions">
          <a href="/Admin/Hospitals/<?php echo e($H->id); ?>/Details" class="btn btn-outline btn-sm">View</a>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($H->status === 'pending'): ?>
            <form method="POST" action="/Admin/Hospitals/<?php echo e($H->id); ?>/Approve" style="margin:0;"><?php echo csrf_field(); ?><button class="btn btn-success btn-sm">Approve</button></form>
            <form method="POST" action="/Admin/Hospitals/<?php echo e($H->id); ?>/Reject" style="margin:0;"><?php echo csrf_field(); ?><button class="btn btn-danger btn-sm">Reject</button></form>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <form method="POST" action="/Admin/Hospitals/<?php echo e($H->id); ?>/Delete" style="margin:0;" onsubmit="return confirm('Delete this hospital?')"><?php echo csrf_field(); ?> <button class="btn btn-danger btn-sm">Del</button></form>
        </div></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text-light);">No hospitals in this view</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Hospitals->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/admin/hospitals.blade.php ENDPATH**/ ?>