

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
                    <div class="gallery-item">
                        <img src="<?php echo e(asset('images/gallery/' . $item->image_path)); ?>" alt="<?php echo e($item->title); ?>">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="gallery-pagination">
                <?php echo e($galleries->appends(request()->query())->links()); ?>

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

<script>
// JS สำหรับเปิด-ปิด Dropdown
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('galleryDropdown');
    dropdown.addEventListener('click', function(e) {
        this.classList.toggle('active');
        e.stopPropagation();
    });
    document.addEventListener('click', () => dropdown.classList.remove('active'));
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/gallery.blade.php ENDPATH**/ ?>