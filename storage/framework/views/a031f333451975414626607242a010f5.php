<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">Vaccine Inventory</div><div class="page-sub">Manage available / unavailable vaccines</div></div>
<div class="header-actions"><a href="/Admin/Vaccines/Create" class="btn btn-primary">+ Add Vaccine</a></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Vaccine</th><th>Manufacturer</th><th>Doses</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Vaccines->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Vaccines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $V): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($V->name); ?></strong><span><?php echo e($V->description ?? ''); ?></span></td>
        <td style="font-size:.79rem;"><?php echo e($V->manufacturer); ?></td>
        <td style="font-size:.79rem;"><?php echo e($V->doses_required); ?></td>
        <td style="font-size:.82rem;font-weight:700;"><?php echo e(number_format($V->total_stock ?? 0)); ?></td>
        <td><span class="badge <?php echo e($V->status==='available'?'badge-success':'badge-danger'); ?>"><?php echo e(ucfirst($V->status)); ?></span></td>
        <td><div class="td-actions">
          <a href="/Admin/Vaccines/<?php echo e($V->id); ?>/Edit" class="btn btn-outline btn-sm">Edit</a>
          <form method="POST" action="/Admin/Vaccines/<?php echo e($V->id); ?>/Delete" style="margin:0;" onsubmit="return confirm('Delete this vaccine?')"><?php echo csrf_field(); ?> <button class="btn btn-danger btn-sm">Del</button></form>
        </div></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--text-light);">No vaccines added</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/admin/vaccines.blade.php ENDPATH**/ ?>