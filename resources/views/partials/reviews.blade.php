<section class="reviews-section py-5">
    <div class="container-fluid position-relative">
        
        <h2 class="text-center fw-bold mb-5 section-title-review">รีวิวจากลูกค้าของเรา</h2>

        <div class="owl-carousel owl-theme reviews-carousel">
            
            {{-- ✅ วนลูปดึงข้อมูลจาก Database --}}
            @foreach($reviews as $review)
            <div class="item">
                <div class="review-card">
                    
                    {{-- 1. คะแนนสินค้า --}}
                    <div class="d-flex align-items-center mb-2">
                        <span class="review-label">คะแนนสินค้า</span>
                        <div class="stars">
                            {{-- Logic การแสดงดาวตามคะแนนใน DB --}}
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $review->product_rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>

                    {{-- 2. คะแนนบริการ --}}
                    <div class="d-flex align-items-center mb-3">
                        <span class="review-label">คะแนนบริการ</span>
                        <div class="stars">
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $review->service_rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>

                    {{-- 3. คอมเมนต์ --}}
                    <p class="review-comment">
                        "{{ $review->comment }}"
                    </p>

                </div>
            </div>
            @endforeach

        </div>

        {{-- ✅ ส่วนที่เพิ่ม: ปุ่มดูรีวิวทั้งหมด (วางไว้ตรงนี้จะอยู่กึ่งกลางใต้สไลด์พอดี)
        <div class="text-center mt-4 mt-lg-5">
            <a href="#" class="btn-view-all-reviews">
                ดูรีวิวทั้งหมด <i class="bi bi-chevron-right" style="font-size: 0.9em;"></i>
            </a>
        </div> --}}

    </div>
</section>

@push('scripts')
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
@endpush