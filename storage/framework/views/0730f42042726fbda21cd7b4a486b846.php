<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <div class="page-title">Two-Factor Authentication Setup</div>
    <div class="page-sub">Manage your security preferences. 2FA is mandatory for Administrators.</div>
  </div>
</div>

<div class="card card-pad" style="max-width: 800px;">
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div style="padding: 15px; background: #eafeea; color: #27ae60; border-radius: 8px; margin-bottom: 20px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
        <div style="padding: 15px; background: #eaf2fb; color: #2980b9; border-radius: 8px; margin-bottom: 20px;">
            <?php echo e(session('info')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div style="margin-bottom: 30px;">
        <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--primary); margin-bottom: 10px;">Select 2FA Method</h3>
        <p style="color: var(--text-sub); font-size: .9rem; margin-bottom: 20px;">Choose how you want to receive your security codes when logging in.</p>
        
        <form method="POST" action="<?php echo e(route('admin.setup-2fa.switch')); ?>">
            <?php echo csrf_field(); ?>
            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                
                <!-- Email Option -->
                <label style="flex: 1; min-width: 200px; border: 2px solid <?php echo e($User->two_factor_method === 'email' ? 'var(--primary)' : 'var(--border)'); ?>; border-radius: 10px; padding: 20px; cursor: pointer; display: flex; align-items: flex-start; gap: 15px; transition: all .2s; background: <?php echo e($User->two_factor_method === 'email' ? '#f4f6f8' : '#fff'); ?>;">
                    <input type="radio" name="method" value="email" <?php echo e($User->two_factor_method === 'email' ? 'checked' : ''); ?> onchange="this.form.submit()" style="margin-top: 5px;">
                    <div>
                        <div style="font-weight: 700; color: var(--primary); margin-bottom: 5px;">Email Authentication</div>
                        <div style="font-size: .85rem; color: var(--text-sub);">Receive a 6-digit code via your registered email address.</div>
                    </div>
                </label>

                <!-- Authenticator Option -->
                <label style="flex: 1; min-width: 200px; border: 2px solid <?php echo e($User->two_factor_method === 'authenticator' ? 'var(--primary)' : 'var(--border)'); ?>; border-radius: 10px; padding: 20px; cursor: pointer; display: flex; align-items: flex-start; gap: 15px; transition: all .2s; background: <?php echo e($User->two_factor_method === 'authenticator' ? '#f4f6f8' : '#fff'); ?>;">
                    <input type="radio" name="method" value="authenticator" <?php echo e($User->two_factor_method === 'authenticator' ? 'checked' : ''); ?> onchange="this.form.submit()" style="margin-top: 5px;">
                    <div>
                        <div style="font-weight: 700; color: var(--primary); margin-bottom: 5px;">Google Authenticator</div>
                        <div style="font-size: .85rem; color: var(--text-sub);">Use an authenticator app (like Google Authenticator) to generate codes.</div>
                    </div>
                </label>

            </div>
        </form>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($User->two_factor_method === 'authenticator'): ?>
        <hr style="border: none; border-top: 1px solid var(--border); margin: 30px 0;">
        <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--primary); margin-bottom: 10px;">Authenticator Configuration</h3>
        
        <!-- Utilizing Fortify's Livewire component for Two Factor Authentication setup -->
        <div style="padding: 20px; background: #fff; border: 1px solid var(--border); border-radius: 10px;">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.two-factor-authentication-form');

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3908962810-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/admin/two-factor-setup.blade.php ENDPATH**/ ?>