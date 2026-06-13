<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">Patient Requests</div><div class="page-sub">Approve or reject COVID test/vaccination requests</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Type</th><th>Message</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Requests->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($request->patient?->user?->name ?? 'N/A'); ?></strong></td>
        <td style="font-size:.79rem;"><?php echo e($request->request_type === 'covid_test' ? 'COVID Test' : 'Vaccination'); ?></td>
        <td style="font-size:.79rem;"><?php echo e($request->message ?? '—'); ?></td>
        <td><span class="badge <?php echo e($request->status==='approved'?'badge-success':($request->status==='rejected'?'badge-danger':'badge-warning')); ?>"><?php echo e(ucfirst($request->status)); ?></span></td>
        <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($request->created_at->format('d M Y')); ?></td>
        <td><div class="td-actions">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($request->status === 'pending'): ?>
            <form method="POST" action="/Hospital/Requests/<?php echo e($request->id); ?>/Approve" style="margin:0;"><?php echo csrf_field(); ?><button class="btn btn-success btn-sm">Approve</button></form>
            <form method="POST" action="/Hospital/Requests/<?php echo e($request->id); ?>/Reject" style="margin:0;"><?php echo csrf_field(); ?><button class="btn btn-danger btn-sm">Reject</button></form>
          <?php else: ?>
            <span style="font-size:.75rem;color:var(--text-light);">—</span>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--text-light);">No requests</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Requests->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/hospital/requests.blade.php ENDPATH**/ ?>