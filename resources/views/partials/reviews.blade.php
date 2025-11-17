<section class="reviews-section py-5">
    <div class="container">
        
        <h2 class="text-center fw-bold mb-5 section-title-review">รีวิวจากลูกค้าของเรา</h2>

        <div class="row g-4 justify-content-center">
            @foreach($reviews as $review)
            <div class="col-md-4">
                <div class="review-card p-4 h-100">
                    
                    <div class="d-flex align-items-center mb-2">
                        <span class="review-label">คะแนนสินค้า</span>
                        <div class="stars ms-2">
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $review->product_rating ? 'text-warning' : 'text-muted-dark' }}"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <span class="review-label">คะแนนบริการ</span>
                        <div class="stars ms-2">
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $review->service_rating ? 'text-warning' : 'text-muted-dark' }}"></i>
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

    </div>
</section>