<?php $__env->startSection('content'); ?>
<div class="page-header"><div><div class="page-title">My Profile</div><div class="page-sub">View and edit your personal information</div></div></div>
<div class="card card-pad" style="max-width:600px;">
  <form method="POST" action="/Patient/Profile">
    <?php echo csrf_field(); ?>
    <div class="form-group">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-input" value="<?php echo e(Auth::user()->name); ?>" required>
    </div>
    <div class="form-group">
      <label class="form-label">Email</label>
      <input type="email" class="form-input" value="<?php echo e(Auth::user()->email); ?>" readonly style="background:#f5f5f5;">
    </div>
    <div class="form-group">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-input" value="<?php echo e(Auth::user()->phone); ?>">
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="dob" class="form-input" value="<?php echo e($Patient->dob ? $Patient->dob->format('Y-m-d') : ''); ?>">
      </div>
      <div class="form-group">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
          <option value="">Select</option>
          <option value="male" <?php echo e($Patient->gender === 'male' ? 'selected' : ''); ?>>Male</option>
          <option value="female" <?php echo e($Patient->gender === 'female' ? 'selected' : ''); ?>>Female</option>
          <option value="other" <?php echo e($Patient->gender === 'other' ? 'selected' : ''); ?>>Other</option>
        </select>
      </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label class="form-label">CNIC</label>
        <input type="text" class="form-input" value="<?php echo e($Patient->cnic ?? ''); ?>" >
      </div>
      <div class="form-group">
        <label class="form-label">Blood Group</label>
        <select name="blood_group" class="form-select">
          <option value="">Select</option>
          <option value="A+" <?php echo e($Patient->blood_group === 'A+' ? 'selected' : ''); ?>>A+</option>
          <option value="A-" <?php echo e($Patient->blood_group === 'A-' ? 'selected' : ''); ?>>A-</option>
          <option value="B+" <?php echo e($Patient->blood_group === 'B+' ? 'selected' : ''); ?>>B+</option>
          <option value="B-" <?php echo e($Patient->blood_group === 'B-' ? 'selected' : ''); ?>>B-</option>
          <option value="AB+" <?php echo e($Patient->blood_group === 'AB+' ? 'selected' : ''); ?>>AB+</option>
          <option value="AB-" <?php echo e($Patient->blood_group === 'AB-' ? 'selected' : ''); ?>>AB-</option>
          <option value="O+" <?php echo e($Patient->blood_group === 'O+' ? 'selected' : ''); ?>>O+</option>
          <option value="O-" <?php echo e($Patient->blood_group === 'O-' ? 'selected' : ''); ?>>O-</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-input" rows="2"><?php echo e($Patient->address ?? ''); ?></textarea>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label class="form-label">City</label>
        <input type="text" name="city" class="form-input" value="<?php echo e($Patient->city ?? ''); ?>">
      </div>
      <div class="form-group">
        <label class="form-label">Emergency Contact</label>
        <input type="text" name="emergency_contact" class="form-input" value="<?php echo e($Patient->emergency_contact ?? ''); ?>">
      </div>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;height:42px;">Update Profile</button>
  </form>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
  <div class="alert-box error" style="margin-top:14px;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $E): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div><?php echo e($E); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/patient/profile.blade.php ENDPATH**/ ?>