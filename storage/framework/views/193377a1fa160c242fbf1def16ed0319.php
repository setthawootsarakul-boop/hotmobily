

<?php $__env->startSection('title', 'แจ้งชำระเงินสำเร็จ - Hotmobily'); ?>


<?php $__env->startSection('content'); ?>
<div class="payment-success-container">
    <div class="success-card">
        <div class="success-icon-box">
            <img src="<?php echo e(asset('images/green-mail.png')); ?>" alt="Success" class="success-img">
        </div>

        <h1 class="success-title">แจ้งชำระเงินสำเร็จ</h1>
        
        <p class="success-description">
            ทีมงานได้รับการแจ้งชำระเงินแล้ว<br>
            และจะรีบติดต่อกลับไปในไม่ช้า
        </p>

        <div class="success-action-buttons">
            <a href="<?php echo e(route('home')); ?>" class="btn-primary-action">
               กลับไปหน้าหลัก
            </a>
            <a href="<?php echo e(route('products.index')); ?>" class="btn-secondary-action">
               ดูสินค้าของเรา
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/payment-success.blade.php ENDPATH**/ ?>