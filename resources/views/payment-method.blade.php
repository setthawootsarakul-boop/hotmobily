@extends('layouts.main')

@section('title', 'วิธีการชำระเงิน - Hotstrap')

@section('content')
{{-- เชื่อมต่อไฟล์ CSS เฉพาะหน้า --}}
<link rel="stylesheet" href="{{ asset('css/payment-method.css') }}">

<div class="payment-page">
    <div class="container">
        <h2 class="main-title">วิธีการชำระเงิน</h2>

        {{-- เริ่ม Grid ครอบทั้ง 4 กล่อง --}}
        <div class="payment-grid">
            
            <div class="info-card">
                <div class="card-header">
                    <span class="card-icon">1</span>
                    <h5 class="payment-condition-title">เงื่อนไขการชำระเงิน</h5>
                </div>
                <div class="card-body" style="font-size: 20px !important; font-weight: normal !important;">
                    <ul class="main-condition-list" style="font-weight: normal !important;">
                        <li>ในกรณีที่คำสั่งซื้อมูลค่า <span class="text-red">น้อยกว่า 10,000 บาท</span> ลูกค้าจะ<span class="text-red-underline">ต้องชำระเงินเต็มจำนวน</span></li>
                        <li>ในกรณีที่<span class="text-red">คำสั่งซื้อมูลค่า 10,000 – 50,000 บาท</span>
                            <ul class="sub-condition-list" style="font-weight: normal !important;">
                                <li>ลูกค้า<span class="text-red">นิติบุคคล</span> → <span class="text-red-underline">ชำระมัดจำ 50%</span> ของยอดสั่งซื้อ</li>
                                <li>ลูกค้า<span class="text-red">ทั่วไป</span> → <span class="text-red-underline">ชำระเต็มจำนวน</span></li>
                            </ul>
                        </li>
                        <li>ในกรณีที่<span class="text-red">คำสั่งซื้อมูลค่า มากกว่า 50,000 บาท</span> → <span class="text-red-underline">กรุณาติดต่อสอบถาม</span>เงื่อนไขการมัดจำได้ทางอีเมล contact_hs@hotstrapthai.com หรือโทร 02-637-8995</li>
                    </ul>
                </div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <span class="card-icon">2</span>
                    <h5 class="payment-detail-title">รายละเอียดการชำระเงิน</h5>
                </div>
                <div class="card-body" style="font-size: 20px !important; font-weight: normal !important;">
                    
                    <div class="payment-method-section mb-5">
                        <p class="method-sub-title" style="font-size: 20px !important; font-weight: normal !important; margin-bottom: 15px;">1.โอนเงินมาที่</p>
                        <div class="bank-banner-wrapper">
                            <picture>
                                <source srcset="{{ asset('images/scb-logo-mobile.png') }}" media="(max-width: 768px)">
                                <img src="{{ asset('images/scb-logo.png') }}" alt="SCB Payment Info" class="bank-banner-img">
                            </picture>
                            <button id="copyAccountBtn" class="copy-btn-overlay">คัดลอก</button>
                        </div>
                    </div>

                    <div class="payment-method-section">
                        <p class="method-sub-title" style="font-size: 20px !important; font-weight: normal !important; margin-bottom: 15px;">
                            2.ลูกค้าสามารถเดินทางมาชำระเงินด้วยตนเองได้ที่
                        </p>
                        <div class="location-detail-group" style="display: flex; align-items: flex-start; gap: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: #ffc800; font-size: 24px; margin-top: 5px; margin-left: 100px;"></i>
                            <p class="address-text-full" style="font-size: 20px !important; font-weight: normal !important; line-height: 1.7; margin: 0;">
                                23/34-35 อาคารโครงการเดอะไพร์ม หัวลำโพง อาคาร A <br>
                                ห้องเลขที่ 303 ชั้นที่ 3 ซอยสุกร แขวงตลาดน้อย เขตสัมพันธวงศ์ กรุงเทพมหานคร 10100
                            </p>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="info-card">
                <div class="card-header">
                    <span class="card-icon">3</span>
                    <h5 class="payment-detail-title">ระยะเวลาการผลิตและจัดส่ง</h5>
                </div>
                <div class="card-body" style="font-size: 20px !important; font-weight: normal !important;">
                    <div class="production-banner-wrapper mb-4">
                        <picture>
                            <img src="{{ asset('images/timeline.png') }}" alt="ระยะเวลาการผลิต" class="bank-banner-img">
                        </picture>
                    </div>

                    <div class="production-notes" style="margin-left: 60px;">
                        <p style="margin-bottom: 10px; font-weight: bold !important;">** หมายเหตุ **</p>
                        <ul style="list-style-type: disc; padding-left: 25px; line-height: 1.8;">
                            <li style="list-style: none; margin-left: -25px; margin-bottom: 10px;">
                                <span class="text-red">กรณีที่สั่งผลิตสินค้า ไม่เกิน 3,000 ชิ้น</span>
                            </li>
                            <li>หากต้องการสั่ง 3,000 ชิ้นขึ้นไป กรุณาติดต่อพนักงานขาย</li>
                            <li>วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์</li>
                            <li>
                                หากต้องการใช้สินค้าเร่งด่วนสามารถสอบถามระยะเวลาการผลิตแบบด่วนได้<br>
                                <span style="font-size: 18px; color: #666;">(อาจมีค่าใช้จ่ายเพิ่มเติม)</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <span class="card-icon">4</span>
                    <h5 class="payment-detail-title">การยกเลิกและเปลี่ยนแปลงคำสั่งซื้อ</h5>
                </div>
                <div class="card-body" style="font-size: 20px !important; font-weight: normal !important; color: #000;">
                    <div class="cancel-step mb-3" style="margin-left: 100px;">
                        <p style="margin-bottom: 5px;">1.หากยัง ไม่ได้ชำระเงิน → ระบบจะยกเลิกรายการอัตโนมัติภายใน 7 วัน</p>
                    </div>

                    <div class="cancel-step" style="margin-left: 100px;">
                        <p style="margin-bottom: 10px;">2.หาก ชำระเงินแล้ว → การยกเลิกจะมีค่าธรรมเนียมตามเงื่อนไข</p>
                        <ul style="list-style-type: disc; padding-left: 50px; line-height: 1.8; margin-bottom: 20px; color: #000;">
                            <li>ยกเลิกภายใน 3 วัน → หัก 30% ของยอดสั่งซื้อ</li>
                            <li>ยกเลิกภายใน 6 วัน → หัก 50% ของยอดสั่งซื้อ</li>
                            <li>ยกเลิกหลังจาก 6 วันขึ้นไป → หัก 100% ของยอดสั่งซื้อ</li>
                        </ul>
                    </div>
                    
                    <p style="text-align: center; margin-top: 30px; font-weight: bold !important;">
                        *** <span style="text-decoration: underline; text-underline-offset: 5px;">สำหรับข้อสงสัยเพิ่มเติม กรุณาติดต่อฝ่ายบริการลูกค้า</span> ***
                    </p>
                </div>
            </div>

        </div> {{-- ปิด payment-grid --}}

        <div class="related-nav">
            <h3 class="nav-title">บทความที่คุณอาจสนใจ</h3>
            <div class="nav-links-container">
                <a href="{{ route('order-guide') }}" class="nav-link-item">
                    <span>ขั้นตอนการสั่งซื้อสินค้า</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="{{ route('faq') }}" class="nav-link-item">
                    <span>คำถามที่พบบ่อย (FAQ)</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="{{ route('design-guide') }}" class="nav-link-item">
                    <span>วิธีการออกแบบ</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="{{ route('shipping-info') }}" class="nav-link-item">
                    <span>การจัดส่งสินค้า</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('copyAccountBtn').addEventListener('click', function() {
        navigator.clipboard.writeText('1912139535');
        const btn = this;
        btn.innerText = 'คัดลอกแล้ว ✓';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.innerText = 'คัดลอก';
            btn.classList.remove('copied');
        }, 2000);
    });
</script>
@endsection