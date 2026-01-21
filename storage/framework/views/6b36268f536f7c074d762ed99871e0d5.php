

<?php $__env->startSection('content'); ?>

<div class="faq-page-wrapper" style="background-color: #fff8ec; min-height: 100vh; margin-top: -1px; padding-top: 1px;">


<div class="faq-header">
  <h1>คำถามที่พบบ่อย (FAQ)</h1>
</div>

<!-- 🔸 กรอบรายการคำถาม -->
<div class="faq-list">
  <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="faq-box active">
      <div class="faq-question">
        Q : <?php echo e($faq->question); ?>

      </div>
      <div class="faq-answer">
        A : <?php echo nl2br(e($faq->answer)); ?>

        <?php if($faq->faq_image_1): ?>
          <div style="margin-top: 10px;">
            <img src="<?php echo e(asset('storage/' . $faq->faq_image_1)); ?>" alt="FAQ Image 1" style="max-width: 100%; border-radius: 8px;">
          </div>
        <?php endif; ?>
        <?php if($faq->faq_image_2): ?>
          <div style="margin-top: 10px;">
            <img src="<?php echo e(asset('storage/' . $faq->faq_image_2)); ?>" alt="FAQ Image 2" style="max-width: 100%; border-radius: 8px;">
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  <div class="pagination">
    <?php echo e($faqs->links('pagination::bootstrap-4')); ?>

  </div>
</div>

<!-- ✅ ปุ่มอยู่นอกกรอบ -->
<div class="faq-contact-area" style="text-align: center; margin-top: 50px;">
  <a href="<?php echo e(route('contact.full')); ?>" class="faq-contact-btn">
    หาคำตอบไม่เจอใช่มั้ย ให้เราช่วยสิ ส่งข้อความหาเรา
  </a>
</div>

<!-- =========================
     🔹 ส่วนที่ 2: บทความที่คุณอาจสนใจ
========================= -->
<div class="faq-header" style="padding-top: 20px;">
  <h1>บทความที่คุณอาจสนใจ</h1>
</div>

<div class="faq-section">
  <div class="faq-item" onclick="location.href='<?php echo e(route('order-guide')); ?>#how-to-order'">
    ขั้นตอนการสั่งซื้อสินค้า
  </div>
  <div class="faq-item" onclick="location.href='<?php echo e(route('design-guide')); ?>#design'">
    วิธีการออกแบบ
  </div>
  <div class="faq-item" onclick="location.href='<?php echo e(route('payment-method')); ?>#section4'"> 
      วิธีการยกเลิกคำสั่งซื้อ
  </div>
    <div class="faq-item" onclick="location.href='<?php echo e(route('payment-method')); ?>#section3'"> การจัดส่งสินค้า</div>
  </div>
</div>

<!-- 🧩 แสดง/ซ่อนคำตอบ -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const questions = document.querySelectorAll('.faq-question');
  questions.forEach(q => {
    q.addEventListener('click', () => {
      const box = q.parentElement;
      box.classList.toggle('active');
    });
  });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/faq.blade.php ENDPATH**/ ?>