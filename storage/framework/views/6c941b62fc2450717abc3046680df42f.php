


<?php $__env->startPush('styles'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<style>
    .gallery-grid a {
        text-decoration: none;
        display: block;
        cursor: zoom-in;
    }
    .gallery-item {
        transition: transform 0.3s ease;
    }
    .gallery-item:hover {
        transform: scale(1.02);
    }
    /* ปรับแต่งตำแหน่งคำอธิบายใต้รูปใน Lightbox */
    .lb-caption {
        font-family: 'Prompt', sans-serif;
        font-size: 16px;
        font-weight: 400;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="gallery-outer-wrapper">
    <div class="page-container">
        
        <h2 class="gallery-main-title">ผลงานผลิตและออกแบบ</h2>

        
        <div class="filter-section-top">
            <div class="custom-gallery-dropdown" id="galleryDropdown">
                <div class="dropdown-trigger">
                    <span>
                        <?php if(request('product')): ?>
                            <?php echo e($products_list->firstWhere('id', request('product'))->name); ?>

                        <?php else: ?>
                            สินค้าทั้งหมด
                        <?php endif; ?>
                    </span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <ul class="dropdown-menu-list">
                    <li class="<?php echo e(!request('product') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('gallery.index')); ?>">สินค้าทั้งหมด</a>
                        <?php if(!request('product')): ?> <span class="check-icon">✓</span> <?php endif; ?>
                    </li>
                    <?php $__currentLoopData = $products_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e(request('product') == $prod->id ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('gallery.index', ['product' => $prod->id])); ?>"><?php echo e($prod->name); ?></a>
                            <?php if(request('product') == $prod->id): ?> <span class="check-icon">✓</span> <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>

        <div class="gallery-content-box">
            <div class="gallery-grid">
                <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <a href="<?php echo e(asset('images/gallery/' . $item->image_path)); ?>" 
                       data-lightbox="product-gallery" 
                       data-title="<?php echo e($item->title ?? 'ผลงานจาก Hotmobily'); ?>">
                        <div class="gallery-item">
                            <img src="<?php echo e(asset('images/gallery/' . $item->image_path)); ?>" alt="<?php echo e($item->title); ?>">
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="gallery-pagination-wrapper mt-5">
                <?php echo e($galleries->links('pagination::bootstrap-4')); ?>

            </div>
        </div>

        
        <div class="gallery-category-nav">
            <div class="nav-row">
                <a href="<?php echo e(route('gallery.index')); ?>" class="cat-btn <?php echo e(!request('product') ? 'active' : ''); ?>">แสดงทั้งหมด</a>
                <?php $__currentLoopData = $products_list->whereIn('id', [3, 19, 20, 21]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('gallery.index', ['product' => $prod->id])); ?>" class="cat-btn <?php echo e(request('product') == $prod->id ? 'active' : ''); ?>"><?php echo e($prod->name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="nav-row">
                <?php $__currentLoopData = $products_list->whereIn('id', [15, 11, 13, 12, 4]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('gallery.index', ['product' => $prod->id])); ?>" class="cat-btn <?php echo e(request('product') == $prod->id ? 'active' : ''); ?>"><?php echo e($prod->name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="nav-row">
                <?php $__currentLoopData = $products_list->whereIn('id', [5, 6, 7, 8]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('gallery.index', ['product' => $prod->id])); ?>" class="cat-btn <?php echo e(request('product') == $prod->id ? 'active' : ''); ?>"><?php echo e($prod->name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // JS สำหรับเปิด-ปิด Dropdown เดิมของคุณ
        const dropdown = document.getElementById('galleryDropdown');
        if (dropdown) {
            dropdown.addEventListener('click', function(e) {
                this.classList.toggle('active');
                e.stopPropagation();
            });
            document.addEventListener('click', () => dropdown.classList.remove('active'));
        }

        // ตั้งค่า Option สำหรับ Lightbox2
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true,
          'albumLabel': "ภาพที่ %1 จาก %2",
          'alwaysShowNavOnTouchDevices': true,
          'fadeDuration': 300,
          'imageFadeDuration': 300
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/gallery.blade.php ENDPATH**/ ?>