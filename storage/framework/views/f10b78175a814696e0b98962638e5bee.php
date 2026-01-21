

<?php $__env->startSection('title', 'ส่งข้อความสำเร็จ - Hotmobily'); ?>



<?php $__env->startSection('content'); ?>
<div class="success-section">
    <div class="success-card">
        
        <img src="<?php echo e(asset('images/green-mail.png')); ?>" alt="Success" class="success-icon-img">
        
        <h1>ขอบคุณที่ติดต่อเรา</h1>
        <p>ทีมงานได้รับข้อความแล้ว<br>และจะรีบติดต่อกลับไปในไม่ช้า</p>
        
        <a href="<?php echo e(url('/')); ?>" class="btn-home">กลับไปหน้าหลัก</a>
        <a href="<?php echo e(url('/products')); ?>" class="btn-products">ดูสินค้าของเรา</a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/contact-success.blade.php ENDPATH**/ ?>