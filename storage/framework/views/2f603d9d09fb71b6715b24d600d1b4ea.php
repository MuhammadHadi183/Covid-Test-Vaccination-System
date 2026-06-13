<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-title">Vaccination records</div>
    <div class="page-sub">Add records and update vaccination status</div>
  </div>
</div>

<div class="card card-pad mb-28" style="max-width:640px;">
  <div class="sec-title" style="margin-bottom:12px;">Add vaccination record</div>
  <p style="font-size:.78rem;color:var(--text-sub);margin-bottom:16px;">Patients listed here have either an <strong>approved request</strong> or a <strong>vaccination appointment</strong> at your hospital. Choose a vaccine with <strong>stock</strong> (quantity &gt; 0). Marking a dose as <strong>completed</strong> reduces stock by one. Completing a vaccination appointment from the Appointments page also creates a record and uses stock.</p>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
    <div class="alert-box error" style="margin-bottom:14px;">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $errorMessage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div><?php echo e($errorMessage); ?></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <form method="POST" action="/Hospital/Vaccinations">
    <?php echo csrf_field(); ?>
    <div class="form-group">
      <label class="form-label">Patient</label>
      <select name="patient_id" class="form-select" required>
        <option value="">Select patient</option>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $PatientsForVax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($patient->id); ?>" <?php echo e((string) old('patient_id') === (string) $patient->id ? 'selected' : ''); ?>>
            <?php echo e($patient->user->name ?? 'Patient #'.$patient->id); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($patient->cnic): ?> — <?php echo e($patient->cnic); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </select>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($PatientsForVax->isEmpty()): ?>
        <p style="margin-top:8px;font-size:.78rem;color:var(--warning);">No approved patients yet. Approve a request under Requests first.</p>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div class="form-group">
      <label class="form-label">Vaccine (in stock)</label>
      <select name="vaccine_id" class="form-select" required>
        <option value="">Select vaccine</option>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $VaccineStocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($stockRow->vaccine_id); ?>" <?php echo e((string) old('vaccine_id') === (string) $stockRow->vaccine_id ? 'selected' : ''); ?>>
            <?php echo e($stockRow->vaccine->name ?? 'Vaccine #'.$stockRow->vaccine_id); ?> — qty <?php echo e($stockRow->quantity); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </select>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($VaccineStocks->isEmpty()): ?>
        <p style="margin-top:8px;font-size:.78rem;color:var(--warning);">No stock with quantity &gt; 0. Add stock under Vaccine stock.</p>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label class="form-label">Dose number</label>
        <input type="number" name="dose_number" class="form-input" min="1" max="10" value="<?php echo e(old('dose_number', 1)); ?>" required>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="scheduled" <?php echo e(old('status', 'scheduled') === 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
          <option value="completed" <?php echo e(old('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
          <option value="cancelled" <?php echo e(old('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Notes (optional)</label>
      <textarea name="notes" class="form-input" rows="2" placeholder="Optional notes"><?php echo e(old('notes')); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Add record</button>
  </form>
</div>

<div class="page-header" style="margin-bottom:16px;"><div><div class="page-title" style="font-size:1.05rem;">All records at your hospital</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Vaccine</th><th>Dose</th><th>Status</th><th>Date</th><th>Update</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Vaccinations->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Vaccinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vaccination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($vaccination->patient->user->name ?? 'N/A'); ?></strong></td>
        <td style="font-size:.79rem;"><?php echo e($vaccination->vaccine->name ?? 'N/A'); ?></td>
        <td style="font-size:.79rem;">Dose <?php echo e($vaccination->dose_number); ?></td>
        <td><span class="badge <?php echo e($vaccination->status==='completed'?'badge-success':($vaccination->status==='cancelled'?'badge-danger':'badge-warning')); ?>"><?php echo e(ucfirst($vaccination->status)); ?></span></td>
        <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($vaccination->vaccinated_at ? $vaccination->vaccinated_at->format('d M Y') : 'Pending'); ?></td>
        <td>
          <form method="POST" action="/Hospital/Vaccinations/<?php echo e($vaccination->id); ?>/Update" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
            <?php echo csrf_field(); ?>
            <select name="status" class="form-select" style="width:120px;padding:4px 8px;font-size:.76rem;">
              <option value="scheduled" <?php echo e($vaccination->status==='scheduled'?'selected':''); ?>>Scheduled</option>
              <option value="completed" <?php echo e($vaccination->status==='completed'?'selected':''); ?>>Completed</option>
              <option value="cancelled" <?php echo e($vaccination->status==='cancelled'?'selected':''); ?>>Cancelled</option>
            </select>
            <button class="btn btn-primary btn-sm">Save</button>
          </form>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('status')): ?>
            <div style="font-size:.72rem;color:var(--danger);margin-top:4px;"><?php echo e($errors->first('status')); ?></div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--text-light);">No vaccination records</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Vaccinations->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/hospital/vaccinations.blade.php ENDPATH**/ ?>