<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-title">COVID-19 test results</div>
    <div class="page-sub">Add new tests and update results for your hospital</div>
  </div>
</div>

<div class="card card-pad mb-28" style="max-width:640px;">
  <div class="sec-title" style="margin-bottom:12px;">Add COVID test result</div>
  <p style="font-size:.78rem;color:var(--text-sub);margin-bottom:16px;">Only patients with an <strong>approved request</strong> at your hospital can be selected.</p>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
    <div class="alert-box error" style="margin-bottom:14px;">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $errorMessage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div><?php echo e($errorMessage); ?></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <form method="POST" action="/Hospital/Covid-Results">
    <?php echo csrf_field(); ?>
    <div class="form-group">
      <label class="form-label">Patient</label>
      <select name="patient_id" class="form-select" required>
        <option value="">Select patient</option>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($patient->id); ?>" <?php echo e((string) old('patient_id') === (string) $patient->id ? 'selected' : ''); ?>>
            <?php echo e($patient->user->name ?? 'Patient #'.$patient->id); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($patient->cnic): ?> — <?php echo e($patient->cnic); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </select>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Patients->isEmpty()): ?>
        <p style="margin-top:8px;font-size:.78rem;color:var(--warning);">No approved patients yet. Approve a request under Requests first.</p>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label class="form-label">Test type</label>
        <select name="test_type" class="form-select" required>
          <option value="PCR" <?php echo e(old('test_type') === 'PCR' ? 'selected' : ''); ?>>PCR</option>
          <option value="Antigen RAT" <?php echo e(old('test_type') === 'Antigen RAT' ? 'selected' : ''); ?>>Antigen RAT</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Result</label>
        <select name="result" class="form-select">
          <option value="pending" <?php echo e(old('result', 'pending') === 'pending' ? 'selected' : ''); ?>>Pending</option>
          <option value="negative" <?php echo e(old('result') === 'negative' ? 'selected' : ''); ?>>Negative</option>
          <option value="positive" <?php echo e(old('result') === 'positive' ? 'selected' : ''); ?>>Positive</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">CT value (optional)</label>
      <input type="number" step="0.01" name="ct_value" class="form-input" value="<?php echo e(old('ct_value')); ?>" placeholder="e.g. 18.5">
    </div>
    <div class="form-group">
      <label class="form-label">Notes (optional)</label>
      <textarea name="notes" class="form-input" rows="2" placeholder="Internal notes"><?php echo e(old('notes')); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Add test record</button>
  </form>
</div>

<div class="page-header" style="margin-bottom:16px;"><div><div class="page-title" style="font-size:1.05rem;">All tests at your hospital</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Type</th><th>Result</th><th>CT</th><th>Notes</th><th>Date</th><th>Update</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Tests->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($test->patient->user->name ?? 'N/A'); ?></strong></td>
        <td style="font-size:.79rem;"><?php echo e($test->test_type); ?></td>
        <td><span class="badge <?php echo e($test->result==='positive'?'badge-danger':($test->result==='negative'?'badge-success':'badge-warning')); ?>"><?php echo e(ucfirst($test->result)); ?></span></td>
        <td style="font-size:.82rem;"><?php echo e($test->ct_value ?? '—'); ?></td>
        <td style="font-size:.72rem;color:var(--text-sub);max-width:140px;"><?php echo e(Str::limit($test->notes ?? '—', 40)); ?></td>
        <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($test->created_at->format('d M Y')); ?></td>
        <td>
          <form method="POST" action="/Hospital/Covid-Results/<?php echo e($test->id); ?>/Update" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
            <?php echo csrf_field(); ?>
            <select name="result" class="form-select" style="width:110px;padding:4px 8px;font-size:.76rem;">
              <option value="pending" <?php echo e($test->result==='pending'?'selected':''); ?>>Pending</option>
              <option value="positive" <?php echo e($test->result==='positive'?'selected':''); ?>>Positive</option>
              <option value="negative" <?php echo e($test->result==='negative'?'selected':''); ?>>Negative</option>
            </select>
            <input type="number" step="0.01" name="ct_value" placeholder="CT" value="<?php echo e($test->ct_value); ?>" class="form-input" style="width:70px;padding:4px 8px;font-size:.76rem;">
            <button class="btn btn-primary btn-sm">Save</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text-light);">No test records yet</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Tests->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/hospital/covid-results.blade.php ENDPATH**/ ?>