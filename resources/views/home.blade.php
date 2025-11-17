@extends('layouts.main')

@section('title', 'หน้าแรก | Hotmobily')

@section('content')

<section class="hero-section py-5 position-relative">
    <div class="container text-center text-lg-start">
        <div class="row align-items-center">
            
            {{-- 🟡 รูปภาพหลัก (สไลด์อัตโนมัติ) --}}
            <div class="col-lg-6 text-center mt-4 mt-lg-0 order-1 order-lg-2">
                <img id="heroImage" 
                     src="{{ asset('images/Top page/T-keychain.png') }}" 
                     alt="Hotmobily Product" 
                     class="hero-img fade">
            </div>

            {{-- 🟡 เนื้อหาข้อความ --}}
            <div class="col-lg-6 order-2 order-lg-1">
                <h1 class="fw-bold display-4 mb-3 brand-highlight">Hotmobily</h1>
                <p class="lead mb-4 brand-desc">
                    รับทำพวงกุญแจ เข็มกลัด สแตนดี้ สติ๊กเกอร์ ยางรัดผม แท่นวางโทรศัพท์ ที่รองแก้ว 
                    ยางหุ้มกุญแจ ที่ติดโทรศัพท์ งานอะคริลิค ยาง และงานสะท้อนแสง
                </p>

                <div class="d-flex justify-content-lg-start justify-content-center gap-4 brand-features">
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

    {{-- 🔸 ปุ่มขีดเปลี่ยนรูป --}}
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

    function changeImage(index) {
        heroImage.classList.remove('show');
        setTimeout(() => {
            heroImage.src = images[index];
            heroImage.classList.add('show');
        }, 250);

        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
        currentIndex = index;
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        changeImage(currentIndex);
    }

    function startAutoSlide() {
        autoSlide = setInterval(nextImage, 3000); // ⏱ เปลี่ยนทุก 3 วิ
    }

    function stopAutoSlide() {
        clearInterval(autoSlide);
    }

    window.manualChange = function(index) {
        stopAutoSlide();
        changeImage(index);
        startAutoSlide();
    }

    // ✅ เริ่มทำงานเมื่อโหลดเสร็จ
    heroImage.classList.add('show');
    startAutoSlide();
});
</script>

@endsection
