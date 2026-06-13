<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">View Results</div><div class="page-sub">COVID-19 test results and vaccination details</div></div></div>

<!-- COVID Test Results -->
<div class="mb-28">
  <div class="sec-head"><span class="sec-title">COVID-19 Test Results</span></div>
  <div class="card"><div class="tbl-wrap"><table>
    <thead><tr><th>Test Type</th><th>Result</th><th>CT Value</th><th>Hospital</th><th>Date</th></tr></thead>
    <tbody>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Tests->count() > 0): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $T): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td style="font-size:.82rem;font-weight:600;"><?php echo e($T->test_type); ?></td>
          <td><span class="badge <?php echo e($T->result==='positive'?'badge-danger':($T->result==='negative'?'badge-success':'badge-warning')); ?>"><?php echo e(ucfirst($T->result)); ?></span></td>
          <td style="font-size:.82rem;"><?php echo e($T->ct_value ?? 'N/A'); ?></td>
          <td style="font-size:.79rem;"><?php echo e($T->hospital->hospital_name ?? 'N/A'); ?></td>
          <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($T->created_at->format('d M Y H:i')); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      <?php else: ?>
        <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--text-light);">No test results</td></tr>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </tbody>
  </table></div></div>
</div>

<!-- Vaccination Records -->
<div class="mb-28">
  <div class="sec-head"><span class="sec-title">Vaccination Records</span></div>
  <div class="card"><div class="tbl-wrap"><table>
    <thead><tr><th>Vaccine</th><th>Dose</th><th>Status</th><th>Hospital</th><th>Date</th></tr></thead>
    <tbody>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Vaccinations->count() > 0): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Vaccinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $V): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td style="font-size:.82rem;font-weight:600;"><?php echo e($V->vaccine->name ?? 'N/A'); ?></td>
          <td style="font-size:.79rem;">Dose <?php echo e($V->dose_number); ?></td>
          <td><span class="badge <?php echo e($V->status==='completed'?'badge-success':($V->status==='cancelled'?'badge-danger':'badge-warning')); ?>"><?php echo e(ucfirst($V->status)); ?></span></td>
          <td style="font-size:.79rem;"><?php echo e($V->hospital->hospital_name ?? 'N/A'); ?></td>
          <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($V->vaccinated_at ? $V->vaccinated_at->format('d M Y') : 'Pending'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      <?php else: ?>
        <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--text-light);">No vaccination records</td></tr>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </tbody>
  </table></div></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/patient/reports.blade.php ENDPATH**/ ?>