<style>
    /* 1. คุมขนาด Container หลักไม่ให้เกิน 1240px และจัดกึ่งกลาง */
    .banner-carousel-wrapper { 
        padding: 50px 0; 
        background-color: #F6F1E9; 
    }
    
    .carousel-container-fixed {
        max-width: 1240px; 
        margin: 0 auto;    
        padding: 0 15px;   
    }

    #mainBannerCarousel { 
        overflow: hidden; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
        border-radius: 8px;
    }

    /* 2. Desktop: ล็อคขนาดรูปภาพ 1240x300 */
    .carousel-item {
        width: 100%;
        height: 300px; 
        background-color: transparent; 
    }
    
    .carousel-item img { 
        width: 100%; 
        height: 100%; 
        display: block; 
        object-fit: cover; 
    }
    
    /* 3. ปรับแต่ง Dot แบบขีด */
    .carousel-indicators { 
        bottom: 15px; 
        margin-bottom: 0; 
        gap: 8px; 
    }
    
    .carousel-indicators li, 
    .carousel-indicators [data-bs-target] {
        width: 30px; 
        height: 4px; 
        border-radius: 2px;
        background-color: rgba(255, 255, 255, 0.5);
        border: none; 
        cursor: pointer; 
        transition: all 0.3s ease;
        text-indent: -999px;
        overflow: hidden;
    }
    
    .carousel-indicators .active { 
        background-color: #FFA726 !important; 
        width: 45px; 
    }

    .carousel-control-prev, .carousel-control-next { width: 5%; }

    @media (max-width: 768px) {
        .banner-carousel-wrapper { padding: 20px 0px; }
        .carousel-item { height: auto !important; }
        .carousel-item img { height: auto !important; object-fit: contain !important; }
        .carousel-container-fixed { padding: 0 0px; }
        .carousel-control-prev, .carousel-control-next { width: 12%; }
    }
</style>

<div class="banner-carousel-wrapper">
    <div class="carousel-container-fixed">
        <div id="mainBannerCarousel" class="carousel slide" data-bs-ride="carousel">
            
            
            <?php if(!empty($banners)): ?>
                <ol class="carousel-indicators">
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li data-bs-target="#mainBannerCarousel" 
                            data-bs-slide-to="<?php echo e($key); ?>" 
                            class="<?php echo e($key == 0 ? 'active' : ''); ?>"></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            <?php endif; ?>

            
            <div class="carousel-inner">
                <?php if(!empty($banners)): ?>
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $imgLink = $banner['link'] ?? '#';
                            $imgPath = $banner['banner_img'] ?? null;
                        ?>

                        <?php if($imgPath): ?>
                            <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                                <?php if(!empty($imgLink) && $imgLink !== '#'): ?>
                                    <a href="<?php echo e($imgLink); ?>">
                                        <img src="<?php echo e($imgPath); ?>" class="d-block w-100" alt="Banner">
                                    </a>
                                <?php else: ?>
                                    <img src="<?php echo e($imgPath); ?>" class="d-block w-100" alt="Banner">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <img src="<?php echo e(asset('images/banner/banner1.jpg')); ?>" class="d-block w-100" alt="Default Banner">
                    </div>
                <?php endif; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myCarouselEl = document.querySelector('#mainBannerCarousel');
        if (myCarouselEl) {
            if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
                new bootstrap.Carousel(myCarouselEl, { 
                    interval: 5000, 
                    ride: 'carousel',
                    pause: 'hover'
                });
            } else if (typeof jQuery !== 'undefined') {
                $(myCarouselEl).carousel({ 
                    interval: 5000,
                    pause: 'hover'
                });
            }
        }
    });
</script><?php /**PATH C:\project\hotmobily\resources\views/partials/steps.blade.php ENDPATH**/ ?>