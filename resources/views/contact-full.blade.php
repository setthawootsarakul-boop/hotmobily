@extends('layouts.main')

@section('title', 'ติดต่อเรา')

@section('content')
<section class="contact-section py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5" style="color:#FFA726; font-size:3.3rem;">ติดต่อเรา</h2>

        <div class="row g-5 align-items-start justify-content-center">

            <!-- 🔹 ฝั่งซ้าย -->
            <div class="col-md-5">
                <div class="company-info">

                    <!-- โลโก้ + ชื่อบริษัท -->
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="company-logo me-3">
                        <div class="text-start">
                            <h5 class="fw-bold text-dark mb-1">บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</h5>
                            <p class="text-muted small mb-0">YOU AND EARTH (THAILAND) CO., LTD.</p>
                        </div>
                    </div>

                    <!-- ที่อยู่ -->
                    <p class="text-muted small mb-4 text-start" style="font-size: 15px;">
                        23/34–35 อาคารโปรเจครเดอะไพรด์ หัวลำโพง อาคาร A<br>
                        ห้องเลขที่ 303 ชั้นที่ 3 ซอยสุกร แขวงตลาดน้อย เขตสัมพันธวงศ์<br>
                        กรุงเทพมหานคร 10100<br>
                        เวลาทำการ : จันทร์–ศุกร์ (08:30–17:30 น.)
                    </p>

                    <!-- 🔸 เบอร์โทร + QR -->
                    <div class="contact-box">
                        <div class="phone-list">
                            @foreach ([ 
                                ['064-604-5614', 'tel:0646045614'], 
                                ['02-637-8995', 'tel:026378995'], 
                                ['02-637-8997', 'tel:026378997'] 
                            ] as [$num, $tel])
                            <a href="{{ $tel }}" class="phone-item">
                                <i class="fas fa-phone-alt phone-icon"></i>
                                <span>{{ $num }}</span>
                            </a>
                            @endforeach
                        </div>

                        <div class="qr-box ms-2">
                            <img src="{{ asset('images/line-qr.png') }}" alt="Line QR">
                            <span class="qr-text">Line : hotstrapphai</span>
                        </div>
                    </div>

                    <!-- 🔹 Social icons -->
                    <div class="social-links mt-4">
                        <a href="#" class="social-circle bg-primary text-white"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-circle bg-success text-white"><i class="bi bi-line"></i></a>
                        <a href="#" class="social-circle bg-dark text-white"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-circle bg-danger text-white"><i class="bi bi-envelope-fill"></i></a>
                    </div>
                </div>
            </div>

            <!-- 🔹 ฝั่งขวา -->
            <div class="col-md-7">
                <form action="{{ route('contact.send') }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm border form-lg">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-5">ชื่อ - นามสกุล *</label>
                        <input type="text" name="name" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-5">อีเมล *</label>
                        <input type="email" name="email" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-5">เบอร์โทรศัพท์ *</label>
                        <input type="text" name="phone" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-5">เรื่องที่ต้องการติดต่อ</label>
                        <div class="form-check"><input class="form-check-input" type="checkbox" name="topic[]" value="ขอใบเสนอราคา"> <label class="form-check-label fs-6">ขอใบเสนอราคา</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" name="topic[]" value="นัดหมายฝ่ายขาย"> <label class="form-check-label fs-6">นัดหมายฝ่ายขาย</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" name="topic[]" value="ขอตัวอย่างสินค้า"> <label class="form-check-label fs-6">ขอตัวอย่างสินค้า</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" name="topic[]" value="สอบถามข้อมูลทั่วไป" checked> <label class="form-check-label fs-6">สอบถามข้อมูลทั่วไป</label></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-5">
                            แนบรูปภาพ หรือไฟล์งาน
                            <span class="text-danger small d-block">
                                (***ไฟล์ที่อัปโหลดได้คือ ai, psd, pdf, doc, xls, jpeg, jpg, png, zip ขนาดไม่เกิน 10MB***)
                            </span>
                        </label>
                        <input type="file" name="file" class="form-control form-control-lg">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-5">ส่งข้อความเพิ่มเติม</label>
                        <textarea name="message" class="form-control form-control-lg" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold text-white py-3 shadow-sm" style="background: linear-gradient(90deg,#c38c1e,#b06d0f); font-size:1.1rem;">
                        ส่งข้อความ
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.contact-section {
    background-color: #fff;
}

/* โลโก้ */
.company-logo {
    width: 70px;
    height: auto;
    object-fit: contain;
}

/* กล่องรวมเบอร์โทร + QR */
.contact-box {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 25px;
}

/* เบอร์โทร */
.phone-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.phone-item {
    display: flex;
    align-items: center;
    background-color: #fff6f0;
    border-radius: 30px;
    padding: 8px 16px;
    font-size: 16px;
    font-weight: 500;
    color: #333;
    text-decoration: none;
    transition: 0.3s;
    min-width: 190px;
}

.phone-item:hover {
    background-color: #ffe9d6;
}

.phone-icon {
    color: #0da14b;
    font-size: 17px;
    margin-right: 10px;
}

/* QR */
.qr-box img {
    width: 125px;
    height: 125px;
    object-fit: contain;
}

.qr-text {
    font-size: 14px;
    color: #555;
    margin-top: 6px;
}

/* Social icons */
.social-links {
    display: flex;
    justify-content: flex-start;
    gap: 20px;
    margin-top: 25px;
}

.social-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: all 0.3s ease;
}

.social-circle:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 7px rgba(0, 0, 0, 0.15);
}

/* ปรับขนาดฟอร์ม */
.form-control-lg {
    font-size: 16px;
    padding: 10px 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .contact-box {
        flex-direction: column;
        align-items: center;
    }

    .phone-item {
        width: 100%;
        justify-content: center;
    }

    .social-links {
        justify-content: center;
    }
}
</style>
@endsection
