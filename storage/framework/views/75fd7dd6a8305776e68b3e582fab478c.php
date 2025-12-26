<?php $__env->startSection('content'); ?>
<div class="accessories-outer-wrapper">
    <div class="page-container">
        <h2 class="accessories-main-title">อุปกรณ์เสริม</h2>

        <div class="accessories-content-box">
            
            
            <?php if($standardHooks->isNotEmpty()): ?>
            <div class="accessory-section">
                <h3 class="accessory-type-title">ตะขอมาตราฐาน</h3>
                <div class="accessory-grid">
                    <?php $__currentLoopData = $standardHooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="<?php echo e(asset('images/jp-attachments/attachments/' . $item->image_url)); ?>" alt="<?php echo e($item->part_name); ?>">
                        </div>
                        <p><?php echo e($item->part_name); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <hr class="design-divider">
            <?php endif; ?>

            
            <?php if($otherHooks->isNotEmpty()): ?>
            <div class="accessory-section">
                <h3 class="accessory-type-title">ตะขอแบบอื่นๆ</h3>
                <div class="accessory-grid">
                    <?php $__currentLoopData = $otherHooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="<?php echo e(asset('images/jp-attachments/attachments/' . $item->image_url)); ?>" alt="<?php echo e($item->part_name); ?>">
                        </div>
                        <p>
                            <?php echo e($item->part_name); ?><?php if($item->part_name == 'ห่วงไข่ปลา' && $item->color): ?><?php echo e($item->color); ?><?php endif; ?>
                        </p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <hr class="design-divider">
            <?php endif; ?>

            
            <?php if($standeeBases->isNotEmpty()): ?>
            <div class="accessory-section">
                <h3 class="accessory-type-title">ฐานรองสแตนดี้</h3>
                <div class="accessory-grid">
                    <?php $__currentLoopData = $standeeBases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="<?php echo e(asset('images/jp-attachments/attachments/' . $item->image_url)); ?>" alt="<?php echo e($item->part_name); ?>">
                        </div>
                        <p><?php echo e($item->part_name); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <hr class="design-divider">
            <?php endif; ?>

            
            <?php if($clips->isNotEmpty()): ?>
            <div class="accessory-section">
                <h3 class="accessory-type-title">คลิปหนีบ</h3>
                <div class="accessory-grid">
                    <?php $__currentLoopData = $clips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="<?php echo e(asset('images/jp-attachments/attachments/' . $item->image_url)); ?>" alt="<?php echo e($item->part_name); ?>">
                        </div>
                        <p><?php echo e($item->part_name); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <hr class="design-divider">
            <?php endif; ?>

            
            <?php if($otherParts->isNotEmpty()): ?>
            <div class="accessory-section">
                <h3 class="accessory-type-title">ส่วนประกอบอื่นๆ</h3>
                <div class="accessory-grid">
                    <?php $__currentLoopData = $otherParts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="<?php echo e(asset('images/jp-attachments/attachments/' . $item->image_url)); ?>" alt="<?php echo e($item->part_name); ?>">
                        </div>
                        <p><?php echo e($item->part_name); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Hotmobily\hotmobily\resources\views/accessories.blade.php ENDPATH**/ ?>