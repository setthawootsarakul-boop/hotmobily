

<?php $__env->startSection('title', $pageTitle . ' | Hotmobily'); ?> 

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/products.css')); ?>"> 

<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    
    <div class="offcanvas-header d-flex align-items-center justify-content-between p-3">
        
        <div class="d-flex align-items-center gap-2">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="sidebar-logo mobile-sidebar-logo">
            
            <h5 class="offcanvas-title fw-bold mb-0" id="filterOffcanvasLabel" style="font-size: 1.5rem;color: #000;margin-left: 10px;">
                กรองสินค้า
            </h5>
        </div>

        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="sidebar-body">
            <ul class="list-unstyled">
                <li class="sidebar-link">
                    <a href="<?php echo e(route('products.index')); ?>" class="<?php echo e((!request('category') && !request('material')) ? 'active' : ''); ?>">
                        สินค้าทั้งหมด
                    </a>
                </li>
                <li class="filter-group">
                    <button class="filter-toggle fs-6 <?php echo e(request('category') ? 'active-group' : ''); ?>" 
                            data-bs-toggle="collapse" data-bs-target="#catCollapseMob">
                        หมวดหมู่สินค้า <i class="bi bi-chevron-down caret-icon rotated"></i>
                    </button>
                    <div id="catCollapseMob" class="collapse show">
                        <div class="collapse-wrapper mt-2">
                            <ul class="list-unstyled">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="mb-1">
                                        <a href="<?php echo e(route('products.index', ['category' => $cat->id])); ?>"
                                           class="<?php echo e(request('category') == $cat->id ? 'active' : ''); ?>">
                                            <?php echo e($cat->name); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="filter-group"> 
                    <button class="filter-toggle fs-6 <?php echo e(request('material') ? 'active-group' : ''); ?>" 
                            data-bs-toggle="collapse" data-bs-target="#materialCollapseMob">
                        วัสดุ <i class="bi bi-chevron-down caret-icon rotated"></i>
                    </button>
                    <div id="materialCollapseMob" class="collapse show">
                        <div class="collapse-wrapper mt-2">
                            <ul class="list-unstyled">
                                <?php
                                    $materials = \App\Models\Product::select('base_material')->distinct()->pluck('base_material')->filter();
                                ?>
                                <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="mb-1">
                                        <a href="<?php echo e(route('products.index', array_merge(request()->all(), ['material' => $m]))); ?>"
                                           class="<?php echo e(request('material') == $m ? 'active' : ''); ?>">
                                            <?php echo e($m); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid products-page py-0 py-lg-4"> 
    
    <div class="row align-items-start">
        
        <aside class="col-lg-3 d-none d-lg-block">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" style="color: #333; text-decoration: none;">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: #0d6efd; font-weight: 500;"><?php echo e($pageTitle); ?></li>
                </ol>
            </nav>

            <div class="sidebar-card shadow-sm">
                <div class="sidebar-header d-flex align-items-center gap-3">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="logo" class="sidebar-logo">
                    <h5 class="mb-0">กรองสินค้า</h5>
                </div>
                <hr class="sidebar-divider my-3">
                <div class="sidebar-body">
                    <ul class="list-unstyled">
                        <li class="sidebar-link">
                            <a href="<?php echo e(route('products.index')); ?>" 
                               class=" <?php echo e((!request('category') && !request('material')) ? 'active' : ''); ?>">
                                สินค้าทั้งหมด
                            </a>
                        </li>
                        <li class="filter-group">
                            <button class="filter-toggle <?php echo e(request('category') ? 'active-group' : ''); ?>" 
                                    data-bs-toggle="collapse" data-bs-target="#catCollapse">
                                หมวดหมู่สินค้า <i class="bi bi-chevron-down caret-icon rotated"></i>
                            </button>
                            <div id="catCollapse" class="collapse show">
                                <div class="collapse-wrapper mt-2">
                                    <ul class="list-unstyled">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="mb-1">
                                                <a href="<?php echo e(route('products.index', ['category' => $cat->id])); ?>"
                                                   class="<?php echo e(request('category') == $cat->id ? 'active' : ''); ?>">
                                                    <?php echo e($cat->name); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="filter-group"> 
                            <button class="filter-toggle <?php echo e(request('material') ? 'active-group' : ''); ?>" 
                                    data-bs-toggle="collapse" data-bs-target="#materialCollapse">
                                วัสดุ <i class="bi bi-chevron-down caret-icon rotated"></i>
                            </button>
                            <div id="materialCollapse" class="collapse show">
                                <div class="collapse-wrapper mt-2">
                                    <ul class="list-unstyled">
                                        <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="mb-1">
                                                <a href="<?php echo e(route('products.index', array_merge(request()->all(), ['material' => $m]))); ?>"
                                                   class="<?php echo e(request('material') == $m ? 'active' : ''); ?>">
                                                    <?php echo e($m); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <section class="col-lg-9 p-0 p-lg-3">
            
            <div class="d-block d-lg-none mobile-header-section">
                <div class="px-3 py-2 bg-light-mobile">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0" style="font-size: 0.85rem;">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="text-dark text-decoration-none">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page"><?php echo e($pageTitle); ?></li>
                        </ol>
                    </nav>
                </div>

                <div class="mobile-page-banner d-flex align-items-center justify-content-center">
                    <h2><?php echo e($pageTitle); ?></h2>
                </div>

                <div class="mobile-filter-bar">
                    <button class="btn w-100 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                        <i class="bi bi-sliders"></i> 
                        <span>กรองสินค้า</span>
                    </button>
                </div>
            </div>

            <div class="d-none d-lg-flex align-items-center mb-3">
                <div class="page-banner">
                    <h2><?php echo e($pageTitle); ?></h2>
                </div>

                <div class="decor-blocks d-none d-md-flex ms-auto" style="margin-top: 25px;">
                    <span class="square"></span>
                    <span class="square"></span>
                    <span class="square"></span>
                </div>
            </div>

            <div class="cards-wrapper p-3 shadow-sm bg-white rounded mt-0 mt-lg-0">
                <div class="row g-3">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2-5">
                            <div class="product-card">
                                <?php
                                    $img = $product->images->first();
                                    $src = $img ? $img->image_url : 'images/no-image.png'; 
                                    
                                    // ✅ เตรียม URL ไว้ก่อน เพื่อใช้ซ้ำได้ง่าย
                                    $productLink = $product->slug ? route('products.show', $product->slug) : '#';
                                ?>
                                
                                
                                <a href="<?php echo e($productLink); ?>" class="product-image-container d-block text-decoration-none">
                                    <div class="bg-shape"></div>
                                    
                                    <img src="<?php echo e(asset($src)); ?>" alt="<?php echo e($product->name); ?>" class="product-img-obj">
                                </a>

                                <div class="product-title">
                                    
                                    <a href="<?php echo e($productLink); ?>">
                                        <?php echo e($product->name); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12">
                            <p class="text-muted text-center py-5">ไม่พบสินค้า</p>
                        </div>
                    <?php endif; ?>
                </div> 
            </div> 
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.filter-toggle');
    toggles.forEach(btn => {
        btn.addEventListener('click', () => {
            const caret = btn.querySelector('.caret-icon'); 
            if(caret) caret.classList.toggle('rotated');
        });
    });
    const collapses = document.querySelectorAll('.collapse');
    collapses.forEach(coll => {
        coll.addEventListener('shown.bs.collapse', (e) => {
            const btn = document.querySelector('[data-bs-target="#' + e.target.id + '"]');
            if (btn) btn.querySelector('.caret-icon')?.classList.add('rotated');
        });
        coll.addEventListener('hidden.bs.collapse', (e) => {
            const btn = document.querySelector('[data-bs-target="#' + e.target.id + '"]');
            if (btn) btn.querySelector('.caret-icon')?.classList.remove('rotated');
        });
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/products/index.blade.php ENDPATH**/ ?>