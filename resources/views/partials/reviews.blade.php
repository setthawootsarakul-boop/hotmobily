<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<section class="reviews-section py-5">
    <div class="container position-relative">
        
        <h2 class="text-center fw-bold mb-5 section-title-review">รีวิวจากลูกค้าของเรา</h2>

        <div class="owl-carousel owl-theme reviews-carousel">
            @foreach($reviews as $review)
            <div class="item">
                <div class="review-card p-4 h-100">
                    
                    <div class="d-flex align-items-center mb-2">
                        <span class="review-label me-2">คะแนนสินค้า</span>
                        <div class="stars">
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $review->product_rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <span class="review-label me-2">คะแนนบริการ</span>
                        <div class="stars">
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $review->service_rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>

                    <p class="review-comment mb-0">
                        {{ $review->comment }}
                    </p>

                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn-view-all-reviews">ดูรีวิวทั้งหมด ></a>
        </div>

    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

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
                    stagePadding: 20 
                },
                768:{
                    items: 2
                },
                992:{
                    items: 3
                }
            }
        });
    });
</script>