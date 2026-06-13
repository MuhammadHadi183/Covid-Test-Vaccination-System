<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">All Patients</div><div class="page-sub">View and manage registered patients</div></div>
<div class="header-actions"><a href="/Admin/Patients/Create" class="btn btn-primary">+ Add Patient</a></div></div>
<div class="card card-pad mb-20">
  <form method="GET" action="/Admin/Patients" style="display:flex;gap:10px;">
    <input type="text" name="search" class="form-input" placeholder="Search by name, email or CNIC..." value="<?php echo e(request('search')); ?>" style="max-width:400px;">
    <button type="submit" class="btn btn-primary">Search</button>
  </form>
</div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Name</th><th>Email</th><th>CNIC</th><th>Gender</th><th>City</th><th>Blood</th><th>Joined</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Patients->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $P): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($P->user->name ?? 'N/A'); ?></strong><span><?php echo e($P->user->phone ?? ''); ?></span></td>
        <td style="font-size:.79rem;"><?php echo e($P->user->email ?? 'N/A'); ?></td>
        <td class="td-mono"><?php echo e($P->cnic ?? 'N/A'); ?></td>
        <td style="font-size:.79rem;"><?php echo e(ucfirst($P->gender ?? 'N/A')); ?></td>
        <td style="font-size:.79rem;"><?php echo e($P->city ?? 'N/A'); ?></td>
        <td style="font-size:.79rem;"><?php echo e($P->blood_group ?? 'N/A'); ?></td>
        <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($P->created_at->format('d M Y')); ?></td>
        <td><div class="td-actions">
          <a href="/Admin/Patients/<?php echo e($P->id); ?>/Edit" class="btn btn-outline btn-sm">Edit</a>
          <form method="POST" action="/Admin/Patients/<?php echo e($P->id); ?>/Delete" style="margin:0;" onsubmit="return confirm('Delete this patient?')"><?php echo csrf_field(); ?> <button class="btn btn-danger btn-sm">Del</button></form>
        </div></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="8" style="text-align:center;padding:24px;color:var(--text-light);">No patients found</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Patients->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/admin/patients.blade.php ENDPATH**/ ?>