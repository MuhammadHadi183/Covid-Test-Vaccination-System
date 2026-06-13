<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">COVID-19 Reports</div><div class="page-sub">Select a patient to generate their full report</div></div></div>

<div class="card card-pad mb-28">
  <div class="sec-head" style="margin-bottom:16px;"><span class="sec-title">Generate Report</span></div>
  <form onsubmit="event.preventDefault(); if(this.patient_id.value) window.location.href='/Admin/Reports/Generate/' + this.patient_id.value;" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
    <div class="form-group" style="margin:0;flex:1;min-width:250px;">
      <label class="form-label">Select Patient</label>
      <select name="patient_id" class="form-select" required>
        <option value="">— Choose a patient —</option>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $AllPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $P): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($P->id); ?>"><?php echo e($P->user->name ?? 'N/A'); ?> — <?php echo e($P->user->email ?? ''); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary" style="height:40px;padding:0 28px;">Generate Report</button>
  </form>
</div>

<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient Name</th><th>Email</th><th>CNIC</th><th>City</th><th>Action</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $AllPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $P): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
      <td><strong><?php echo e($P->user->name ?? 'N/A'); ?></strong></td>
      <td style="font-size:.79rem;"><?php echo e($P->user->email ?? 'N/A'); ?></td>
      <td class="td-mono"><?php echo e($P->cnic ?? 'N/A'); ?></td>
      <td style="font-size:.79rem;"><?php echo e($P->city ?? 'N/A'); ?></td>
      <td style="display:flex;gap:8px;">
        <a href="/Admin/Reports/View/<?php echo e($P->id); ?>" class="btn btn-sm" style="background:#e8ecef;color:#2C3E50;">View</a>
        <a href="/Admin/Reports/Generate/<?php echo e($P->id); ?>" class="btn btn-primary btn-sm">Generate Report</a>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/admin/reports.blade.php ENDPATH**/ ?>