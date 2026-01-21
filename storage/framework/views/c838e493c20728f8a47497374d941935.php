<section class="reviews-section py-5">
    <div class="container-fluid position-relative">
        
        <h2 class="text-center fw-bold mb-5 section-title-review">รีวิวจากลูกค้าของเรา</h2>

        <div class="owl-carousel owl-theme reviews-carousel">
            
            
            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item">
                <div class="review-card">
                    
                    
                    <div class="d-flex align-items-center mb-2">
                        <span class="review-label">คะแนนสินค้า</span>
                        <div class="stars">
                            
                            <?php for($i=1; $i<=5; $i++): ?>
                                <i class="bi bi-star-fill <?php echo e($i <= $review->product_rating ? 'text-warning' : 'text-muted'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>

                    
                    <div class="d-flex align-items-center mb-3">
                        <span class="review-label">คะแนนบริการ</span>
                        <div class="stars">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <i class="bi bi-star-fill <?php echo e($i <= $review->service_rating ? 'text-warning' : 'text-muted'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>

                    
                    <p class="review-comment">
                        "<?php echo e($review->comment); ?>"
                    </p>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        
        <div class="text-center mt-4 mt-lg-5">
            <a href="#" class="btn-view-all-reviews">
                ดูรีวิวทั้งหมด <i class="bi bi-chevron-right" style="font-size: 0.9em;"></i>
            </a>
        </div>

    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function(){
        $(".reviews-carousel").owlCarousel({
            loop: true,
            margin: 20,
            nav: true, 
            dots: true,
            autoplay: false,
            navText: ["<i class='bi bi-chevron-left'></i>","<i class='bi bi-chevron-right'></i>"],
            responsive:{
                0:{
                    items: 1,
                    margin: 20,
                    stagePadding: 20
                },
                768:{
                    items: 2,
                    margin: 30
                },
                /* ✅ ตั้งค่า Breakpoint ตามที่เราคุยกันล่าสุด */
                1000:{
                    items: 3, 
                    margin: 40,
                    stagePadding: 0
                },
                1440:{
                    items: 3,
                    margin: 67,
                    stagePadding: 0
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Hotmobily\hotmobily\resources\views/partials/reviews.blade.php ENDPATH**/ ?>