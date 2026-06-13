<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">Booking Details</div><div class="page-sub">All patient appointment bookings</div></div></div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
<div class="card card-pad mb-20">
  <div class="alert-box error">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $errorMessage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div><?php echo e($errorMessage); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Hospital</th><th>Type</th><th>Date</th><th>Time</th><th>Status</th><th>Cancel reason</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Bookings->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($booking->patient->user->name ?? 'N/A'); ?></strong></td>
        <td style="font-size:.79rem;"><?php echo e($booking->hospital->hospital_name ?? 'N/A'); ?></td>
        <td style="font-size:.79rem;"><?php echo e($booking->type === 'covid_test' ? 'COVID Test' : 'Vaccination'); ?></td>
        <td style="font-size:.79rem;"><?php echo e($booking->appointment_date->format('d M Y')); ?></td>
        <td style="font-size:.79rem;"><?php echo e($booking->time_slot ?? 'N/A'); ?></td>
        <td><span class="badge <?php echo e($booking->status==='completed'?'badge-success':($booking->status==='cancelled'?'badge-danger':($booking->status=='confirmed' ? 'badge-info' : 'badge-warning'))); ?>"><?php echo e(ucfirst($booking->status)); ?></span></td>
        <td style="font-size:.72rem;color:var(--text-sub);max-width:140px;"><?php echo e($booking->status === 'cancelled' ? Str::limit($booking->cancel_reason ?? '—', 80) : '—'); ?></td>
        <td><div class="td-actions" style="flex-direction:column;align-items:stretch;gap:8px;">
          <form method="POST" action="/Admin/Bookings/<?php echo e($booking->id); ?>/Status" style="display:flex;flex-wrap:wrap;gap:6px;margin:0;align-items:flex-start;">
            <?php echo csrf_field(); ?>
            <div style="display:flex;flex-direction:column;gap:6px;min-width:140px;">
              <select name="status" class="form-select appt-status" style="width:100%;padding:3px 6px;font-size:.74rem;">
                <option value="pending" <?php echo e($booking->status==='pending'?'selected':''); ?>>Pending</option>
                <option value="confirmed" <?php echo e($booking->status==='confirmed'?'selected':''); ?>>Confirmed</option>
                <option value="completed" <?php echo e($booking->status==='completed'?'selected':''); ?>>Completed</option>
                <option value="cancelled" <?php echo e($booking->status==='cancelled'?'selected':''); ?>>Cancelled</option>
              </select>
              <textarea name="cancel_reason" class="form-input appt-cancel-reason" rows="2" style="font-size:.72rem;padding:6px;display:none;" placeholder="Reason for cancellation (required)"><?php echo e(old('cancel_reason', $booking->cancel_reason)); ?></textarea>
            </div>
            <button class="btn btn-primary btn-sm" style="align-self:flex-start;">Save</button>
          </form>
          <form method="POST" action="/Admin/Bookings/<?php echo e($booking->id); ?>/Delete" style="margin:0;" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?> <button class="btn btn-danger btn-sm">Del</button></form>
        </div></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="8" style="text-align:center;padding:24px;color:var(--text-light);">No bookings yet</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Bookings->links()); ?></div>
<script>
document.querySelectorAll('.appt-status').forEach(function (statusSelect) {
  var form = statusSelect.closest('form');
  var cancelTextarea = form ? form.querySelector('.appt-cancel-reason') : null;
  function updateCancelBox() {
    if (!cancelTextarea) {
      return;
    }
    var showCancel = statusSelect.value === 'cancelled';
    cancelTextarea.style.display = showCancel ? 'block' : 'none';
    if (!showCancel) {
      cancelTextarea.value = '';
    }
  }
  statusSelect.addEventListener('change', updateCancelBox);
  updateCancelBox();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/admin/bookings.blade.php ENDPATH**/ ?>