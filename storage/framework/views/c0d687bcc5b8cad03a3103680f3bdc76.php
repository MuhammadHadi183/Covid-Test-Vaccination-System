<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">My requests</div><div class="page-sub">Requests you sent to hospitals and their status</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Hospital</th><th>Type</th><th>Your message</th><th>Status</th><th>Date</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Requests->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($request->hospital?->hospital_name ?? 'N/A'); ?></strong></td>
        <td style="font-size:.79rem;"><?php echo e($request->request_type === 'covid_test' ? 'COVID test' : 'Vaccination'); ?></td>
        <td style="font-size:.77rem;color:var(--text-sub);max-width:220px;"><?php echo e($request->message ?? '—'); ?></td>
        <td><span class="badge <?php echo e($request->status==='approved'?'badge-success':($request->status==='rejected'?'badge-danger':'badge-warning')); ?>"><?php echo e(ucfirst($request->status)); ?></span></td>
        <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($request->created_at->format('d M Y')); ?></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--text-light);">No requests yet. <a href="/Patient/Search-Hospitals" style="color:var(--secondary);">Find a hospital</a> and submit a request.</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Requests->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/patient/requests.blade.php ENDPATH**/ ?>