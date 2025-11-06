@extends('layouts.main')

@section('title', 'ติดต่อเรา')

@section('content')
<section class="contact-section py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5" style="color:#FFA726; font-size:3.3rem;">ติดต่อเรา</h2>

        <!-- 🔹 โลโก้ + ชื่อบริษัท (มือถือ) -->
        <div class="company-header-mobile d-flex align-items-center justify-content-center text-center mb-4 d-md-none">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="company-logo-mobile me-3">
            <div class="text-start">
                <h5 class="fw-bold text-dark mb-1 company-name-mobile">
                    บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด
                </h5>
                <p class="text-muted small mb-0 company-en-mobile">
                    YOU AND EARTH (THAILAND) CO., LTD.
                </p>
            </div>
        </div>

        <div class="row g-5 align-items-start justify-content-center flex-md-row flex-column">

            <!-- 🔹 ฝั่งซ้าย (ข้อมูลบริษัท + เบอร์โทร + QR + Social) -->
            <div class="col-md-5 company-side order-2 order-md-1">
                <div class="company-info text-start" style="margin-left:20px;">

                    <!-- Desktop โลโก้ -->
                    <div class="d-none d-md-flex align-items-center mb-4 justify-content-start">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="company-logo me-3">
                        <div class="text-start">
                            <h5 class="fw-bold text-dark mb-1" style="font-size:1.2rem;">
                                บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด
                            </h5>
                            <p class="text-muted small mb-0" style="font-size:0.95rem;">
                                YOU AND EARTH (THAILAND) CO., LTD.
                            </p>
                        </div>
                    </div>

                    <!-- 🔹 ที่อยู่ -->
                    <p class="text-muted small mb-4 company-address text-start" style="font-size:1rem; line-height:1.8;">
                        23/34–35 อาคารโปรเจครเดอะไพรด์ หัวลำโพง อาคาร A<br>
                        ห้องเลขที่ 303 ชั้นที่ 3 ซอยสุกร แขวงตลาดน้อย เขตสัมพันธวงศ์<br>
                        กรุงเทพมหานคร 10100<br>
                        เวลาทำการ : จันทร์–ศุกร์ (08:30–17:30 น.)
                    </p>

                    <!-- 🔹 เบอร์โทร + QR -->
                    <div class="contact-layout-desktop d-none d-md-flex align-items-start justify-content-start gap-4">

                        <!-- 📞 เบอร์โทร -->
                        <div class="phone-list">
                            @foreach ([['064-604-5614', 'tel:0646045614'], ['02-637-8995', 'tel:026378995'], ['02-637-8997', 'tel:026378997']] as [$num, $tel])
                            <a href="{{ $tel }}" class="phone-item">
                                <div class="phone-icon-circle">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <span class="phone-number">{{ $num }}</span>
                            </a>
                            @endforeach
                        </div>

                        <!-- 🔹 QR LINE -->
                        <div class="qr-box text-center">
                            <div class="qr-frame shadow-frame mx-auto">
                                <img src="{{ asset('images/line-qr.png') }}" alt="Line QR">
                            </div>
                            <p class="qr-text mt-3">Line : hotstrapphai</p>
                        </div>
                    </div>

                    <!-- 🔹 โลโก้ Social -->
                    <div class="social-links-horizontal d-none d-md-flex justify-content-start mt-4 gap-3">
                        <a href="#" class="social-circle bg-primary text-white"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-circle bg-success text-white"><i class="bi bi-line"></i></a>
                        <a href="#" class="social-circle bg-dark text-white"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-circle bg-danger text-white"><i class="bi bi-envelope-fill"></i></a>
                    </div>

                    <!-- 🔸 Mobile -->
                    <div class="d-md-none contact-box flex-column align-items-center text-center">
                        <div class="phone-list">
                            @foreach ([['064-604-5614', 'tel:0646045614'], ['02-637-8995', 'tel:026378995'], ['02-637-8997', 'tel:026378997']] as [$num, $tel])
                            <a href="{{ $tel }}" class="phone-item">
                                <div class="phone-icon-circle">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <span class="phone-number">{{ $num }}</span>
                            </a>
                            @endforeach
                        </div>

                        <div class="qr-box mt-4 text-center">
                            <div class="qr-frame mx-auto">
                                <img src="{{ asset('images/line-qr.png') }}" alt="Line QR">
                            </div>
                            <p class="qr-text mt-3">Line : hotstrapphai</p>
                        </div>

                        <div class="social-links mt-4 justify-content-center">
                            <a href="#" class="social-circle bg-primary text-white"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-circle bg-success text-white"><i class="bi bi-line"></i></a>
                            <a href="#" class="social-circle bg-dark text-white"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="social-circle bg-danger text-white"><i class="bi bi-envelope-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔹 ฝั่งขวา (ฟอร์ม) -->
            <div class="col-md-7 order-1 order-md-2 form-side text-start">
                <form action="{{ route('contact.send') }}" method="POST" enctype="multipart/form-data"
                    class="p-5 bg-white rounded shadow-sm border form-lg">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-5">ชื่อ - นามสกุล *</label>
                        <input type="text" name="name" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-5">อีเมล *</label>
                        <input type="email" name="email" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-5">เบอร์โทรศัพท์ *</label>
                        <input type="text" name="phone" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-5">เรื่องที่ต้องการติดต่อ</label>
                        @foreach (['ขอใบเสนอราคา', 'นัดหมายฝ่ายขาย', 'ขอตัวอย่างสินค้า', 'สอบถามข้อมูลทั่วไป'] as $topic)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="topic[]" value="{{ $topic }}" {{ $topic == 'สอบถามข้อมูลทั่วไป' ? 'checked' : '' }}>
                            <label class="form-check-label fs-5">{{ $topic }}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-5">แนบไฟล์งาน</label>
                        <input type="file" name="file" class="form-control form-control-lg">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-5">ข้อความเพิ่มเติม</label>
                        <textarea name="message" class="form-control form-control-lg" rows="4"></textarea>
                    </div>

                    <button type="submit"
                        class="btn btn-warning w-100 fw-bold text-white py-3 shadow-sm"
                        style="background: linear-gradient(90deg,#e7a21d,#b06d0f); font-size:1.2rem;">
                        ส่งข้อความ
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- 🔹 ส่วนฟีเจอร์บริษัทในเครือ -->
<section class="network-section py-5" style="background-color: #F6F1E9;">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">เว็บไซต์ในเครือบริษัทของเรา</h2>
        <div class="row justify-content-center g-4">
            <div class="col-10 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <a href="https://www.youandearth-th.com/" target="_blank">
                    <img src="{{ asset('images/youandearth.png') }}" class="img-fluid network-logo" alt="You and Earth">
                </a>
            </div>
            <div class="col-10 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <a href="https://hotstrapthai.com/" target="_blank">
                    <img src="{{ asset('images/hotstrap.png') }}" class="img-fluid network-logo" alt="Hotstrap">
                </a>
            </div>
            <div class="col-10 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <a href="https://hotmobilythai.com/" target="_blank">
                    <img src="{{ asset('images/hotmobilythai.png') }}" class="img-fluid network-logo" alt="Hotmobilythai">
                </a>
            </div>
            <div class="col-10 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <a href="https://silicone-wristband-studio.jp/" target="_blank">
                    <img src="{{ asset('images/silicone.png') }}" class="img-fluid network-logo" alt="Silicone Wristband Studio">
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />


@endsection
