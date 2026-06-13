<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">Approved Patients</div><div class="page-sub">Patients approved for COVID-19 tests</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Request Type</th><th>Message</th><th>Date</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Patients->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patientRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($patientRequest->patient?->user?->name ?? 'N/A'); ?></strong><span><?php echo e($patientRequest->patient?->user?->email ?? ''); ?></span></td>
        <td style="font-size:.79rem;"><?php echo e($patientRequest->request_type === 'covid_test' ? 'COVID Test' : 'Vaccination'); ?></td>
        <td style="font-size:.79rem;"><?php echo e($patientRequest->message ?? '—'); ?></td>
        <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($patientRequest->created_at->format('d M Y')); ?></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="4" style="text-align:center;padding:24px;color:var(--text-light);">No approved patients</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Patients->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/hospital/patients.blade.php ENDPATH**/ ?>