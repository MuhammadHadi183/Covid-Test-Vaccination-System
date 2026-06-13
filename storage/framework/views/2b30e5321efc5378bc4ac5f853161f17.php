<?php $__env->startSection('content'); ?>
<?php
  $hospital = $Hospital;
  $doctorsList = is_array($hospital->doctors_list) ? $hospital->doctors_list : [];
  $featuredDoctorsList = is_array($hospital->special_doctors) ? $hospital->special_doctors : [];
  $specialtiesList = is_array($hospital->specialties) ? $hospital->specialties : [];
  $facilitiesList = is_array($hospital->facilities) ? $hospital->facilities : [];
  $reviewsList = is_array($hospital->reviews) ? $hospital->reviews : [];
  $medicinesList = is_array($hospital->medicines) ? $hospital->medicines : [];
  $rating = (float) ($hospital->rating ?? 0);
  $fullStars = (int) round(min(5, max(0, $rating)));
?>
<style>
.hosp-hero { display: flex; flex-wrap: wrap; gap: 24px; align-items: flex-start; padding: 24px 26px; background: linear-gradient(135deg, var(--primary) 0%, #1a252f 100%); border-radius: var(--radius-lg); color: #fff; margin-bottom: 24px; }
.hosp-hero-logo { width: 88px; height: 88px; border-radius: var(--radius-md); object-fit: cover; background: rgba(255,255,255,.12); border: 2px solid rgba(255,255,255,.2); }
.hosp-hero-main { flex: 1; min-width: 200px; }
.hosp-hero h1 { font-size: 1.35rem; font-weight: 800; margin-bottom: 6px; letter-spacing: -.02em; }
.hosp-hero-stars { color: #F1C40F; font-size: 1rem; letter-spacing: 2px; margin-top: 4px; }
.info-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px; margin-bottom: 24px; }
.info-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 16px 18px; box-shadow: var(--shadow-sm); }
.info-card h4 { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-sub); margin-bottom: 10px; }
.info-card p { font-size: .86rem; color: var(--text-main); line-height: 1.45; }
.tag-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; background: #E8F4FD; color: #15527A; font-size: .74rem; font-weight: 600; margin: 4px 6px 4px 0; }
.tag-badge.fac { background: #E8F8EF; color: #1A6B3C; }
.review-item { border-bottom: 1px solid var(--border); padding: 14px 0; }
.review-item:last-child { border-bottom: none; }
.review-stars { color: #F39C12; font-size: .85rem; letter-spacing: 1px; }
</style>

<div class="page-header">
  <div>
    <div class="page-title"><?php echo e($hospital->hospital_name); ?></div>
    <div class="page-sub">Public hospital profile</div>
  </div>
  <a href="/Patient/Search-Hospitals" class="btn btn-outline">Back to search</a>
</div>

<div class="hosp-hero">
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hospital->logo): ?>
    <img src="<?php echo e(asset($hospital->logo)); ?>" alt="" class="hosp-hero-logo">
  <?php else: ?>
    <div class="hosp-hero-logo" style="display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;opacity:.5;"><?php echo e(strtoupper(substr($hospital->hospital_name, 0, 1))); ?></div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <div class="hosp-hero-main">
    <h1><?php echo e($hospital->hospital_name); ?></h1>
    <div class="hosp-hero-stars" title="<?php echo e(number_format($rating, 1)); ?> / 5">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = range(1, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $starIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($starIndex <= $fullStars ? '★' : '☆'); ?>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      <span style="font-size:.78rem;opacity:.9;margin-left:8px;"><?php echo e(number_format($rating, 1)); ?> (<?php echo e((int)($hospital->total_reviews ?? 0)); ?> reviews)</span>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hospital->vaccineStocks->count() > 0): ?>
      <div style="margin-top:14px;font-size:.75rem;opacity:.9;">Vaccine availability:
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $hospital->vaccineStocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <span style="margin-right:10px;"><?php echo e($stockRow->vaccine->name ?? ''); ?> (<?php echo e($stockRow->quantity); ?>)</span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>

<div class="info-cards">
  <div class="info-card">
    <h4>Contact</h4>
    <p><strong>Profile email</strong><br><?php echo e($hospital->email ?? '—'); ?></p>
    <p style="margin-top:8px;"><strong>Phone</strong><br><?php echo e($hospital->phone ?? '—'); ?></p>
    <p style="margin-top:8px;"><strong>Website</strong><br><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hospital->website): ?><a href="<?php echo e(Str::startsWith($hospital->website, ['http://','https://']) ? $hospital->website : 'https://' . $hospital->website); ?>" target="_blank" rel="noopener" style="color:var(--secondary);"><?php echo e($hospital->website); ?></a><?php else: ?> — <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></p>
    <p style="margin-top:8px;"><strong>City / address</strong><br><?php echo e($hospital->city ?? '—'); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hospital->address): ?><br><span style="color:var(--text-sub);font-size:.8rem;"><?php echo e($hospital->address); ?></span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></p>
  </div>
  <div class="info-card">
    <h4>Capacity &amp; services</h4>
    <p>Rooms: <strong><?php echo e((int)($hospital->total_rooms ?? 0)); ?></strong></p>
    <p>Beds: <strong><?php echo e((int)($hospital->total_beds ?? 0)); ?></strong></p>
    <p>ICU beds: <strong><?php echo e((int)($hospital->icu_beds ?? 0)); ?></strong></p>
    <p style="margin-top:10px;">Emergency 24/7: <strong><?php echo e($hospital->emergency_available ? 'Yes' : 'No'); ?></strong></p>
    <p>Ambulance: <strong><?php echo e($hospital->ambulance_available ? 'Yes' : 'No'); ?></strong></p>
  </div>
  <div class="info-card">
    <h4>About</h4>
    <p>Established: <strong><?php echo e($hospital->established_year ?? '—'); ?></strong></p>
    <p style="margin-top:8px;">Hours: <strong><?php echo e($hospital->operating_hours ?? '—'); ?></strong></p>
    <p style="margin-top:10px;font-size:.8rem;color:var(--text-sub);"><?php echo e($hospital->description ? Str::limit($hospital->description, 400) : 'No description.'); ?></p>
  </div>
</div>

<div class="col-1-1 mb-28">
  <div class="card card-pad">
    <div class="sec-title" style="margin-bottom:12px;">Specialties</div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($specialtiesList) > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $specialtiesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialtyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <span class="tag-badge"><?php echo e($specialtyName); ?></span>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <p style="color:var(--text-light);font-size:.83rem;">None listed.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
  <div class="card card-pad">
    <div class="sec-title" style="margin-bottom:12px;">Services &amp; facilities</div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($facilitiesList) > 0): ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $facilitiesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facilityName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <span class="tag-badge fac"><?php echo e($facilityName); ?></span>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
      <p style="color:var(--text-light);font-size:.83rem;">None listed.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>

<div class="card mb-28">
  <div class="card-pad" style="border-bottom:1px solid var(--border);"><span class="sec-title">Available doctors</span></div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Name</th><th>Specialty</th><th>Qualification</th><th>Phone</th></tr></thead>
      <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($doctorsList) > 0): ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $doctorsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><strong><?php echo e($doctor['name'] ?? '—'); ?></strong></td>
            <td><?php echo e($doctor['specialty'] ?? '—'); ?></td>
            <td class="td-mono"><?php echo e($doctor['qualification'] ?? '—'); ?></td>
            <td><?php echo e($doctor['phone'] ?? '—'); ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
          <tr><td colspan="4" style="text-align:center;padding:20px;color:var(--text-light);">No doctors listed.</td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card mb-28">
  <div class="card-pad" style="border-bottom:1px solid var(--border);"><span class="sec-title">Special / featured doctors</span></div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Name</th><th>Specialty</th><th>Qualification</th><th>Phone</th></tr></thead>
      <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($featuredDoctorsList) > 0): ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $featuredDoctorsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><strong><?php echo e($doctor['name'] ?? '—'); ?></strong></td>
            <td><?php echo e($doctor['specialty'] ?? '—'); ?></td>
            <td class="td-mono"><?php echo e($doctor['qualification'] ?? '—'); ?></td>
            <td><?php echo e($doctor['phone'] ?? '—'); ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
          <tr><td colspan="4" style="text-align:center;padding:20px;color:var(--text-light);">None listed.</td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card mb-28">
  <div class="card-pad" style="border-bottom:1px solid var(--border);"><span class="sec-title">Medicines &amp; pharmacy</span></div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Name</th><th>Stock</th><th>Unit</th><th>Notes</th></tr></thead>
      <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($medicinesList) > 0): ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $medicinesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><strong><?php echo e($medicine['name'] ?? '—'); ?></strong></td>
            <td><?php echo e($medicine['stock'] ?? '—'); ?></td>
            <td><?php echo e($medicine['unit'] ?? '—'); ?></td>
            <td class="td-mono"><?php echo e($medicine['notes'] ?? '—'); ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
          <tr><td colspan="4" style="text-align:center;padding:20px;color:var(--text-light);">No medicines listed.</td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card card-pad mb-28">
  <div class="sec-title" style="margin-bottom:16px;">Reviews</div>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($reviewsList) > 0): ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reviewsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
      $reviewRating = (float) ($review['rating'] ?? 0);
      $reviewFullStars = (int) round(min(5, max(0, $reviewRating)));
    ?>
    <div class="review-item">
      <strong style="font-size:.88rem;"><?php echo e($review['reviewer'] ?? 'Anonymous'); ?></strong>
      <div class="review-stars">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = range(1, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $starIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($starIndex <= $reviewFullStars ? '★' : '☆'); ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <span style="color:var(--text-sub);font-size:.72rem;margin-left:6px;"><?php echo e($review['date'] ?? ''); ?></span>
      </div>
      <p style="margin-top:8px;font-size:.84rem;color:var(--text-main);line-height:1.5;"><?php echo e($review['comment'] ?? ''); ?></p>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <?php else: ?>
    <p style="color:var(--text-light);font-size:.83rem;">No reviews yet.</p>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<div class="card card-pad">
  <div class="sec-title" style="margin-bottom:14px;">Request a service</div>
  <div style="display:flex;flex-wrap:wrap;gap:10px;">
    <form method="POST" action="/Patient/Request" style="margin:0;"><?php echo csrf_field(); ?>
      <input type="hidden" name="hospital_id" value="<?php echo e($hospital->id); ?>">
      <input type="hidden" name="request_type" value="covid_test">
      <button class="btn btn-outline">Request COVID test</button>
    </form>
    <form method="POST" action="/Patient/Request" style="margin:0;"><?php echo csrf_field(); ?>
      <input type="hidden" name="hospital_id" value="<?php echo e($hospital->id); ?>">
      <input type="hidden" name="request_type" value="vaccination">
      <button class="btn btn-primary">Request vaccination</button>
    </form>
    <a href="/Patient/Book-Appointment" class="btn btn-outline">Book appointment</a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/patient/hospital-show.blade.php ENDPATH**/ ?>