<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">My Appointments</div><div class="page-sub">Track your appointment history</div></div></div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Hospital</th><th>Type</th><th>Date</th><th>Time</th><th>Status</th><th>Notes</th><th>Cancellation</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Appointments->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($appointment->hospital->hospital_name ?? 'N/A'); ?></strong></td>
        <td style="font-size:.79rem;"><?php echo e($appointment->type === 'covid_test' ? 'COVID Test' : 'Vaccination'); ?></td>
        <td style="font-size:.79rem;"><?php echo e($appointment->appointment_date?->format('d M Y') ?? '—'); ?></td>
        <td style="font-size:.82rem;font-weight:700;"><?php echo e($appointment->time_slot ?? '—'); ?></td>
        <td><span class="badge <?php echo e($appointment->status==='completed'?'badge-success':($appointment->status==='cancelled'?'badge-danger':($appointment->status==='confirmed'?'badge-info':'badge-warning'))); ?>"><?php echo e(ucfirst($appointment->status)); ?></span></td>
        <td style="font-size:.77rem;color:var(--text-sub);"><?php echo e($appointment->notes ?? '—'); ?></td>
        <td style="font-size:.75rem;color:var(--text-sub);max-width:200px;"><?php echo e($appointment->status === 'cancelled' ? ($appointment->cancel_reason ?? '—') : '—'); ?></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text-light);">No appointments yet. <a href="/Patient/Book-Appointment" style="color:var(--secondary);">Book one now</a></td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Appointments->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/patient/appointments.blade.php ENDPATH**/ ?>