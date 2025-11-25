@extends('layouts.main')

@section('title', 'หน้าแรก | Hotmobily')

@section('content')

{{-- 
    ✅ Hero Section 
    - ปรับเป็น w-100 เพื่อให้พื้นหลังเต็มจอ
    - ใช้ container-xxl เพื่อให้เนื้อหาข้างในกว้างพอดีกับจอ 1440px 
--}}
<section class="hero-section position-relative w-100">
    <div class="container-xxl text-center text-lg-start h-100">
        <div class="row align-items-center h-100 pt-5 pb-5">
            
            {{-- 🟡 รูปภาพหลัก (สไลด์อัตโนมัติ) --}}
            <div class="col-lg-6 text-center mt-4 mt-lg-0 order-1 order-lg-2 position-relative">
                <div class="hero-img-container">
                    <img id="heroImage" 
                         src="{{ asset('images/Top page/T-keychain.png') }}" 
                         alt="Hotmobily Product" 
                         class="hero-img fade-effect">
                </div>
            </div>

            {{-- 🟡 เนื้อหาข้อความ --}}
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="hero-content-wrapper ps-lg-4">
                    <h1 class="fw-bold display-4 mb-3 brand-highlight">Hotmobily</h1>
                    <p class="lead mb-4 brand-desc">
                        รับทำพวงกุญแจ เข็มกลัด สแตนดี้ สติ๊กเกอร์ ยางรัดผม แท่นวางโทรศัพท์ <span style="white-space: nowrap">ที่รองแก้ว</span> 
                        ยางหุ้มกุญแจ ที่ติดโทรศัพท์ งานอะคริลิค ยาง และงานสะท้อนแสง
                    </p>

                    <div class="d-flex justify-content-lg-start justify-content-center gap-4 brand-features flex-wrap">
                        <div class="feature text-center">
                            <div class="icon-circle">
                                <i class="bi bi-box"></i>
                            </div>
                            <p>คุณภาพดี</p>
                        </div>

                        <div class="feature text-center">
                            <div class="icon-circle">
                                <i class="bi bi-alarm"></i>
                            </div>
                            <p>ส่งตรงเวลา</p>
                        </div>

                        <div class="feature text-center">
                            <div class="icon-circle">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <p>สินค้าตามมาตรฐาน</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- 🔸 ปุ่มขีดเปลี่ยนรูป (Absolute Positioning) --}}
    <div class="image-dots-wrapper text-center">
        <div class="image-dots">
            <span class="dot active" onclick="manualChange(0)"></span>
            <span class="dot" onclick="manualChange(1)"></span>
            <span class="dot" onclick="manualChange(2)"></span>
            <span class="dot" onclick="manualChange(3)"></span>
        </div>
    </div>
</section>

{{-- ✅ include ส่วนอื่น --}}
{{-- 
    Note: ส่วน Partials เหล่านี้จะไหลต่อกันลงมา 
    ความสูงรวมจะถึง 4554px ได้ขึ้นอยู่กับ Padding ภายใน Partials เหล่านี้ด้วย 
--}}
@include('partials.why')
@include('partials.steps')
@include('partials.product-showcase')
@include('partials.reviews')
@include('partials.contact')

{{-- 🔸 JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const images = [
        "{{ asset('images/Top page/T-keychain.png') }}",
        "{{ asset('images/Top page/T-phonestand.png') }}",
        "{{ asset('images/Top page/T-standee.png') }}",
        "{{ asset('images/Top page/T-griptok.png') }}"
    ];

    let currentIndex = 0;
    const heroImage = document.getElementById('heroImage');
    const dots = document.querySelectorAll('.dot');
    let autoSlide;

    // Preload images
    images.forEach(src => {
        const img = new Image();
        img.src = src;
    });

    function changeImage(index) {
        heroImage.classList.remove('show');
        
        // รอจังหวะ fade out นิดนึงแล้วเปลี่ยนรูป
        setTimeout(() => {
            heroImage.src = images[index];
            heroImage.classList.add('show');
        }, 250);

        dots.forEach(dot => dot.classList.remove('active'));
        if(dots[index]) dots[index].classList.add('active');
        currentIndex = index;
    }

    function nextImage() {
        let nextIndex = (currentIndex + 1) % images.length;
        changeImage(nextIndex);
    }

    function startAutoSlide() {
        stopAutoSlide(); // Clear existing interval first
        autoSlide = setInterval(nextImage, 3000); 
    }

    function stopAutoSlide() {
        if(autoSlide) clearInterval(autoSlide);
    }

    window.manualChange = function(index) {
        stopAutoSlide();
        changeImage(index);
        startAutoSlide();
    }

    // Init
    if(heroImage) {
        heroImage.classList.add('show');
        startAutoSlide();
    }
});
</script>

@endsection