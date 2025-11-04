@extends('layouts.main')

@section('title', 'ติดต่อเรา')

@section('content')
<section class="contact-section py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-dark">ติดต่อเรา</h2>

        <div class="row g-5 align-items-start">

            <!-- 🔹 คอลัมน์ซ้าย -->
            <div class="col-md-5">
                <!-- โลโก้ + บริษัท -->
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Hotmobily Logo" width="85" class="me-3">
                    <div>
                        <h5 class="fw-bold mb-1">บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</h5>
                    </div>
                </div>

                <p class="text-muted small mb-1 lh-sm">
                    23/34–35 อาคารโครงการเดอะไพรด์ หัวลำโพง อาคาร A<br>
                    ห้องเลขที่ 303 ชั้นที่ 3 ซอยสุกร แขวงตลาดน้อย<br>
                    เขตสัมพันธวงศ์ กรุงเทพมหานคร 10100
                </p>
                <p class="small mb-4 text-muted">เวลาทำการ : จันทร์–ศุกร์ (08:30–17:30 น.)</p>

                <!-- 🔸 เบอร์โทร + QR LINE -->
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <!-- หมายเลขโทรศัพท์ -->
                    <div class="d-flex flex-column gap-2">
                        <a href="tel:0646045614" class="contact-item d-flex align-items-center">
                            <div class="icon-circle me-2">
                                <i class="bi bi-telephone-fill text-success"></i>
                            </div>
                            <span>064-604-5614</span>
                        </a>
                        <a href="tel:026378995" class="contact-item d-flex align-items-center">
                            <div class="icon-circle me-2">
                                <i class="bi bi-telephone-fill text-success"></i>
                            </div>
                            <span>02-637-8995</span>
                        </a>
                        <a href="tel:026378997" class="contact-item d-flex align-items-center">
                            <div class="icon-circle me-2">
                                <i class="bi bi-telephone-fill text-success"></i>
                            </div>
                            <span>02-637-8997</span>
                        </a>
                    </div>

                    <!-- QR Code -->
                    <div class="text-center ms-3 mt-2">
                        <img src="{{ asset('images/line-qr.png') }}" alt="Line QR" width="140" class="rounded shadow-sm mb-2">
                        <p class="small text-muted mb-0">Line : hotstrapthai</p>
                    </div>
                </div>

                <!-- 🔸 Social Icons -->
                <div class="d-flex justify-content-start gap-4 mt-4">
                    <a href="#" class="social-circle bg-primary text-white">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-circle bg-success text-white">
                        <i class="bi bi-line"></i>
                    </a>
                    <a href="#" class="social-circle bg-dark text-white">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="social-circle bg-danger text-white">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>

            <!-- 🔹 คอลัมน์ขวา -->
            <div class="col-md-7">
                <form action="{{ route('contact.send') }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm border">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">ชื่อ - นามสกุล *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">อีเมล *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">เบอร์โทรศัพท์ *</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">เรื่องที่ต้องการติดต่อ</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="topic[]" value="ขอใบเสนอราคา">
                            <label class="form-check-label">ขอใบเสนอราคา</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="topic[]" value="นัดหมายฝ่ายขาย">
                            <label class="form-check-label">นัดหมายฝ่ายขาย</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="topic[]" value="ขอตัวอย่างสินค้า">
                            <label class="form-check-label">ขอตัวอย่างสินค้า</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="topic[]" value="สอบถามข้อมูลทั่วไป" checked>
                            <label class="form-check-label">สอบถามข้อมูลทั่วไป</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            แนบรูปภาพ หรือไฟล์งาน
                            <span class="text-danger small">
                                (***ไฟล์ที่อัปโหลดได้คือ ai, psd, pdf, doc, xls, jpeg, jpg, png, zip ขนาดไม่เกิน 10MB***)
                            </span>
                        </label>
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">ส่งข้อความเพิ่มเติม</label>
                        <textarea name="message" class="form-control" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold text-white py-2 shadow-sm" style="background: linear-gradient(90deg,#c38c1e,#b06d0f);">
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

    .contact-item {
        background-color: #fff6f0;
        border-radius: 30px;
        padding: 6px 14px;
        font-weight: 500;
        font-size: 15px;
        transition: 0.3s;
        text-decoration: none;
        color: #222;
        min-width: 180px;
    }

    .contact-item:hover {
        background-color: #ffe9d6;
    }

    .icon-circle {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background-color: #e8f7ed;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .social-circle {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.3s ease;
    }

    .social-circle:hover {
        transform: translateY(-3px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        .contact-item {
            min-width: 100%;
        }

        .text-center.ms-3.mt-2 {
            margin-left: 0 !important;
            margin-top: 15px !important;
        }

        .d-flex.align-items-center.mb-4 img {
            width: 70px;
        }
    }
</style>
@endsection
