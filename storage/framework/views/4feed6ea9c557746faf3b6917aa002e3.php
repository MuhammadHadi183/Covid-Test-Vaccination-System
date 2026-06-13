<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-title">Patient appointments</div>
    <div class="page-sub">Bookings at your hospital — confirm, complete, or cancel. Completing a <strong>vaccination</strong> visit records the dose and uses one unit of stock.</div>
  </div>
</div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
<div class="card card-pad mb-20">
  <div class="alert-box error">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $errorMessage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div><?php echo e($errorMessage); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($VaccineStocksForAppt) && $VaccineStocksForAppt->isEmpty()): ?>
<div class="card card-pad mb-20">
  <div class="alert-box error" style="background:rgba(180,80,0,.12);border-color:rgba(180,80,0,.35);color:var(--text);">
    You have no vaccine stock (quantity: 0). Add stock under <a href="/Hospital/Vaccine-Stock" style="color:var(--secondary);font-weight:600;">Vaccine stock</a> before you can complete vaccination appointments.
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<div class="card card-pad mb-20">
  <div style="display:flex;flex-wrap:wrap;gap:8px;">
    <a href="/Hospital/Appointments" class="btn <?php echo e(($Status ?? 'all') === 'all' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">All</a>
    <a href="/Hospital/Appointments?status=pending" class="btn <?php echo e(($Status ?? '') === 'pending' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Pending</a>
    <a href="/Hospital/Appointments?status=confirmed" class="btn <?php echo e(($Status ?? '') === 'confirmed' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Confirmed</a>
    <a href="/Hospital/Appointments?status=completed" class="btn <?php echo e(($Status ?? '') === 'completed' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Completed</a>
    <a href="/Hospital/Appointments?status=cancelled" class="btn <?php echo e(($Status ?? '') === 'cancelled' ? 'btn-primary' : 'btn-outline'); ?> btn-sm">Cancelled</a>
  </div>
</div>
<div class="card"><div class="tbl-wrap"><table>
  <thead><tr><th>Patient</th><th>Type</th><th>Date</th><th>Time</th><th>Doctor</th><th>Notes</th><th>Status</th><th>Cancel reason</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($Appointments->count() > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="td-patient"><strong><?php echo e($appointment->patient?->user?->name ?? 'N/A'); ?></strong></td>
        <td style="font-size:.79rem;"><?php echo e($appointment->type === 'covid_test' ? 'COVID test' : 'Vaccination'); ?></td>
        <td style="font-size:.79rem;"><?php echo e($appointment->appointment_date?->format('d M Y') ?? '—'); ?></td>
        <td style="font-size:.79rem;"><?php echo e($appointment->time_slot ?? '—'); ?></td>
        <td style="font-size:.79rem;color:var(--primary);font-weight:600;"><?php echo e($appointment->doctor_name ?? '—'); ?></td>
        <td style="font-size:.72rem;color:var(--text-sub);max-width:160px;"><?php echo e(Str::limit($appointment->notes ?? '—', 48)); ?></td>
        <td><span class="badge <?php echo e($appointment->status==='completed'?'badge-success':($appointment->status==='cancelled'?'badge-danger':($appointment->status==='confirmed'?'badge-info':'badge-warning'))); ?>"><?php echo e(ucfirst($appointment->status)); ?></span></td>
        <td style="font-size:.72rem;color:var(--text-sub);max-width:140px;"><?php echo e($appointment->status === 'cancelled' ? Str::limit($appointment->cancel_reason ?? '—', 80) : '—'); ?></td>
        <td>
          <form method="POST" action="/Hospital/Appointments/<?php echo e($appointment->id); ?>/Status" data-appointment-type="<?php echo e($appointment->type); ?>" style="display:flex;gap:6px;align-items:flex-start;flex-wrap:wrap;margin:0;max-width:320px;">
            <?php echo csrf_field(); ?>
            <div style="display:flex;flex-direction:column;gap:6px;flex:1;min-width:160px;">
              <select name="status" class="form-select appt-status" style="width:100%;padding:4px 8px;font-size:.76rem;">
                <option value="pending" <?php echo e($appointment->status==='pending'?'selected':''); ?>>Pending</option>
                <option value="confirmed" <?php echo e($appointment->status==='confirmed'?'selected':''); ?>>Confirmed</option>
                <option value="completed" <?php echo e($appointment->status==='completed'?'selected':''); ?>>Completed</option>
                <option value="cancelled" <?php echo e($appointment->status==='cancelled'?'selected':''); ?>>Cancelled</option>
              </select>
              <textarea name="cancel_reason" class="form-input appt-cancel-reason" rows="2" style="font-size:.72rem;padding:6px 8px;display:none;" placeholder="Reason for cancellation (required)"><?php echo e(old('cancel_reason', $appointment->cancel_reason)); ?></textarea>
              <div class="appt-doctor-wrap" style="display:none;">
                <select name="doctor_name" class="form-select" style="width:100%;padding:4px 8px;font-size:.74rem;">
                  <option value="">Select Doctor (required)…</option>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($Hospital->doctors_list)): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $Hospital->doctors_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php $docName = is_array($doc) ? ($doc['name'] ?? 'Doctor') : (is_object($doc) ? ($doc->name ?? 'Doctor') : $doc); ?>
                      <option value="<?php echo e($docName); ?>" <?php echo e($appointment->doctor_name === $docName ? 'selected' : ''); ?>>
                        <?php echo e($docName); ?>

                      </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
              </div>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->type === 'vaccination'): ?>
              <div class="appt-vax-wrap" style="display:none;">
                <label class="form-label" style="font-size:.72rem;margin-bottom:4px;">Vaccine given</label>
                <select name="vaccine_id" class="form-select" style="width:100%;padding:4px 8px;font-size:.74rem;">
                  <option value="">Select vaccine…</option>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $VaccineStocksForAppt ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($stockRow->vaccine_id); ?>" <?php echo e($appointment->vaccinationRecord && (string) $appointment->vaccinationRecord->vaccine_id === (string) $stockRow->vaccine_id ? 'selected' : ''); ?>>
                      <?php echo e($stockRow->vaccine->name ?? 'Vaccine'); ?> (<?php echo e($stockRow->quantity); ?>)
                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
                <label class="form-label" style="font-size:.72rem;margin:8px 0 4px;">Dose number</label>
                <input type="number" name="dose_number" class="form-input" min="1" max="10" value="<?php echo e($appointment->vaccinationRecord?->dose_number ?? 1); ?>" style="padding:6px 8px;font-size:.76rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->vaccinationRecord): ?>
                  <p style="margin:6px 0 0;font-size:.68rem;color:var(--text-sub);">Dose already on file for this visit.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-start;">Save</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <tr><td colspan="8" style="text-align:center;padding:24px;color:var(--text-light);">No appointments</td></tr>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </tbody>
</table></div></div>
<div class="pagination-wrap"><?php echo e($Appointments->links()); ?></div>
<script>

document.querySelectorAll('form[action*="/Hospital/Appointments/"][action$="/Status"]').forEach(function (form) {
  var statusSelect = form.querySelector('.appt-status');
  var cancelTextarea = form.querySelector('.appt-cancel-reason');
  var doctorBox = form.querySelector('.appt-doctor-wrap');
  var vaccineBox = form.querySelector('.appt-vax-wrap');
  var appointmentType = form.getAttribute('data-appointment-type');

  function updateExtraFields() {
    if (!statusSelect) {
      return;
    }
    var status = statusSelect.value;

    if (cancelTextarea) {
      var showCancel = status === 'cancelled';
      cancelTextarea.style.display = showCancel ? 'block' : 'none';
      if (!showCancel) {
        cancelTextarea.value = '';
      }
    }

    if (doctorBox) {
      var showDoctor = status === 'confirmed' || status === 'completed';
      doctorBox.style.display = showDoctor ? 'block' : 'none';
    }

    if (vaccineBox && appointmentType === 'vaccination') {
      var showVaccine = status === 'completed';
      vaccineBox.style.display = showVaccine ? 'block' : 'none';
      if (!showVaccine) {
        var vaccineSelect = vaccineBox.querySelector('select[name="vaccine_id"]');
        var doseInput = vaccineBox.querySelector('input[name="dose_number"]');
        if (vaccineSelect) {
          vaccineSelect.selectedIndex = 0;
        }
        if (doseInput) {
          doseInput.value = '1';
        }
      }
    }
  }

  if (statusSelect) {
    statusSelect.addEventListener('change', updateExtraFields);
    updateExtraFields();
  }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/hospital/appointments.blade.php ENDPATH**/ ?>