@extends('layouts.main')

@section('title', 'หน้าแรก | Hotmobily')

@section('content')

{{-- 1️⃣ Import Swiper CSS & Custom CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('css/hero.css') }}"> 

<section class="hero-section position-relative w-100">
    <div class="container-xxl text-center text-lg-start h-100">
        <div class="row align-items-center h-100 pb-5">
            
            {{-- 🟡 ฝั่งรูปภาพและหัวข้อมือถือ (Image Column) --}}
            <div class="col-lg-6 text-center mt-4 mt-lg-0 order-1 order-lg-2 position-relative">
                
                {{-- 🚩 หัวข้อสำหรับมือถือ: วางไว้บนสุดเหนือ hero-img-container --}}
                <h1 class="display-4 mb-3 brand-highlight d-lg-none">Hotmobily</h1>

                <div class="hero-img-container">
                    <div class="swiper myHeroSwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset('images/Top-page/T-keychain.png') }}" class="hero-img" alt="Keychain">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('images/Top-page/T-phonestand.png') }}" class="hero-img" alt="Phone Stand">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('images/Top-page/T-standee.png') }}" class="hero-img" alt="Standee">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('images/Top-page/T-griptok.png') }}" class="hero-img" alt="Griptok">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ปุ่ม Dots อยู่ใต้รูปภาพ --}}
                <div class="custom-pagination"></div>
            </div>

            {{-- 🟡 ฝั่งเนื้อหาข้อความ --}}
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="hero-content-wrapper ps-lg-4">
                    {{-- 🚩 หัวข้อสำหรับ Desktop (ซ่อนบนมือถือ) --}}
                    <h1 class="display-4 mb-3 brand-highlight d-none d-lg-block">Hotmobily</h1>
                    
                    <p class="lead mb-4 brand-desc">
                        รับทำพวงกุญแจ เข็มกลัด สแตนดี้ สติ๊กเกอร์ ยางรัดผม แท่นวางโทรศัพท์ <span style="white-space: nowrap">ที่รองแก้ว</span> 
                        ยางหุ้มกุญแจ ที่ติดโทรศัพท์ งานอะคริลิค ยาง และงานสะท้อนแสง
                    </p>

                    <div class="d-flex justify-content-lg-start justify-content-center gap-4 brand-features flex-wrap">
                        <div class="feature text-center">
                            <div class="icon-circle">
                                <img src="{{ asset('images/box.png') }}" alt="คุณภาพดี" class="feature-icon">
                            </div>
                            <p>คุณภาพดี</p>
                        </div>
                        <div class="feature text-center">
                            <div class="icon-circle">
                                <img src="{{ asset('images/clock.png') }}" alt="ส่งตรงเวลา" class="feature-icon">
                            </div>
                            <p>ส่งตรงเวลา</p>
                        </div>
                        <div class="feature text-center">
                            <div class="icon-circle">
                                <img src="{{ asset('images/check.png') }}" alt="สินค้าตามมาตรฐาน" class="feature-icon">
                            </div>
                            <p>สินค้าตามมาตรฐาน</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ✅ include ส่วนอื่น --}}
@include('partials.why')
@include('partials.steps')
@include('partials.product-showcase')
@include('partials.reviews')
@include('partials.contact')

{{-- Scripts... --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".myHeroSwiper", {
        spaceBetween: 0, centeredSlides: true, loop: true, speed: 1200,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: ".custom-pagination", clickable: true },
    });
</script>
@endsection