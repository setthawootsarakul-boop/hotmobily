@extends('layouts.main')

@section('title', 'ติดต่อเรา - Hotmobily')

@section('content')
<link rel="stylesheet" href="{{ asset('css/contact-full.css') }}">

<div class="contact-full-page">
    <div class="container-xxl">
        <h2 class="contact-main-title">ติดต่อเรา</h2>

        <div class="contact-flex-wrapper">
            <div class="contact-info-side">
                <div class="company-brand-header">
                    <img src="{{ asset('images/logo.png') }}" alt="Hotmobily" class="brand-logo-img">
                    <div class="brand-text">
                        <strong>บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</strong>
                    </div>
                </div>
                
                <p class="address-detail">
                    23/34-35 อาคารโครงการเดอะไพร์ม หัวลำโพง อาคาร A<br>
                    ห้องเลขที่ 303 ชั้นที่ 3 ซอยสุกร แขวงตลาดน้อย<br>
                    เขตสัมพันธวงศ์ กรุงเทพมหานคร 10100
                </p>
                <p class="work-time">เวลาทำการ : จันทร์-ศุกร์ (08:30-17:30 น.)</p>

                <div class="contact-and-qr-wrapper">
                    <div class="contact-channels">
                        <div class="channel-item">
                            <div class="icon-bg-green"><i class="fas fa-phone"></i></div> 
                            064-604-5614
                        </div>
                        <div class="channel-item">
                            <div class="icon-bg-green"><i class="fas fa-phone"></i></div> 
                            02-637-8995
                        </div>
                        <div class="channel-item">
                            <div class="icon-bg-green"><i class="fas fa-phone"></i></div> 
                            02-637-8997
                        </div>
                    </div>

                    <div class="qr-line-section">
                        <img src="{{ asset('images/line-qr.png') }}" alt="Line QR" class="line-qr-img">
                        <p class="line-id-text">Line : hotstrapthai</p>
                    </div>
                </div>

                <div class="social-icons">
                    <a href="#"><img src="{{ asset('images/fb.png') }}" alt="Facebook"></a>
                    <a href="#"><img src="{{ asset('images/line.png') }}" alt="Line"></a>
                    <a href="#"><img src="{{ asset('images/x.png') }}" alt="X"></a>
                    <a href="#"><img src="{{ asset('images/gmail.png') }}" alt="Email"></a>
                </div>
            </div>

            <div class="contact-form-side">
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label>ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>อีเมล <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>เรื่องที่ต้องการติดต่อ</label>
                        <div class="checkbox-grid">
                            <label><input type="checkbox"> ขอใบเสนอราคา</label>
                            <label><input type="checkbox"> นัดหมายฝ่ายขาย</label>
                            <label><input type="checkbox"> ขอตัวอย่างสินค้า</label>
                            <label><input type="checkbox" checked> สอบถามข้อมูลทั่วไป</label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>แนบรูปภาพ หรือไฟล์งาน <span class="file-note">(***ไฟล์ที่อัปโหลดได้คือ ai, psd, pdf, doc, xls, jpeg, jpg, png, zip ขนาดไม่เกิน 10MB***)</span></label>
                        <div class="file-upload-box">
                            <i class="fas fa-upload"></i>
                            <p>วางไฟล์ลงที่นี่ หรือคลิกเพื่อแนบไฟล์</p>
                            <input type="file" hidden>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label>ส่งข้อความเพิ่มเติม</label>
                        <textarea class="form-control" rows="4" placeholder="ข้อความ"></textarea>
                    </div>

                    <button type="submit" class="btn-send-message">ส่งข้อความ</button>
                </form>
            </div>
        </div>
    </div>

    <section class="network-section">
        <h3 class="network-title">เว็บไซต์ในเครือของเรา</h3>
        <div class="network-grid">
            <div class="network-item"><img src="{{ asset('images/youandearth.png') }}" alt="You and Earth"></div>
            <div class="network-item"><img src="{{ asset('images/hotstrap.png') }}" alt="Hotstrap"></div>
            <div class="network-item"><img src="{{ asset('images/hotmobilythai.png') }}" alt="Hotmobily"></div>
            <div class="network-item"><img src="{{ asset('images/silicone.png') }}" alt="Hand"></div>
        </div>
    </section>
</div>
@endsection