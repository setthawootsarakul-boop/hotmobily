@extends('layouts.main')

@section('title', 'หน้าแรก | Hotmobily')

@section('content')

<section class="hero-section py-5">
    <div class="container text-center text-lg-start">
        <div class="row align-items-center">
            
            {{-- 🟡 รูปภาพแมว (อยู่ขวาใน Desktop / อยู่บนในมือถือ) --}}
            <div class="col-lg-6 text-center mt-4 mt-lg-0 order-1 order-lg-2">
                <img src="{{ asset('images/keychain.png') }}" alt="Hotmobily Product" class="hero-img">
            </div>

            {{-- 🟡 เนื้อหาข้อความ (อยู่ซ้ายใน Desktop / อยู่ล่างในมือถือ) --}}
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
</section>

{{-- ✅ include section อื่น ๆ --}}
@include('partials.why')
@include('partials.steps')
@include('partials.contact')

@endsection
