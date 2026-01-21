@extends('layouts.main')

@section('title', 'วิธีการชำระเงิน - Hotstrap')

@section('content')
{{-- เชื่อมต่อไฟล์ CSS เฉพาะหน้า --}}
<link rel="stylesheet" href="{{ asset('css/payment-method.css') }}">

<div class="payment-page">
    <div class="container">
        <h2 class="main-title">ขั้นตอนและวิธีการชำระเงิน</h2>

        {{-- เริ่ม Grid ครอบทั้ง 4 กล่อง --}}
        <div class="payment-grid">
            
            <div class="info-card">
                <div class="card-header">
                    <span class="card-icon">1</span>
                    <h5 class="payment-condition-title">เงื่อนไขการชำระเงิน</h5>
                </div>
                <div class="card-body">
                    <ul class="main-condition-list">
                        <li>ในกรณีที่คำสั่งซื้อมูลค่า <span class="text-red">น้อยกว่า 10,000 บาท</span> ลูกค้าจะ<span class="text-red-underline">ต้องชำระเงินเต็มจำนวน</span></li>
                        <li>ในกรณีที่<span class="text-red">คำสั่งซื้อมูลค่า 10,000 – 50,000 บาท</span>
                            <ul class="sub-condition-list">
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
                <div class="card-body">
                    <div class="payment-method-section">
                        <p class="method-sub-title">1.โอนเงินมาที่</p>
                        <div class="bank-banner-wrapper">
                            <picture>
                                <source srcset="{{ asset('images/scb-mobile.png') }}" media="(max-width: 768px)">
                                <img src="{{ asset('images/scb-logo.png') }}" alt="SCB Payment Info" class="bank-banner-img">
                            </picture>
                            <button id="copyAccountBtn" class="copy-btn-overlay">คัดลอก</button>
                        </div>
                    </div>

                    <div class="payment-method-section">
                        <p class="method-sub-title">2.ลูกค้าสามารถเดินทางมาชำระเงินด้วยตนเองได้ที่</p>
                        <div class="location-detail-group">
                            <i class="fas fa-map-marker-alt location-marker-icon"></i>
                            <p class="address-text-full">
                                23/34-35 อาคารโครงการเดอะไพร์ม หัวลำโพง อาคาร A <br>
                                ห้องเลขที่ 303 ชั้นที่ 3 ซอยสุกร แขวงตลาดน้อย เขตสัมพันธวงศ์ กรุงเทพมหานคร 10100
                            </p>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="info-card" id="section3">
                <div class="card-header">
                    <span class="card-icon">3</span>
                    <h5 class="payment-detail-title">ระยะเวลาการผลิตและจัดส่ง</h5>
                </div>
                <div class="card-body">
                    <div class="production-banner-wrapper mb-4">
                        <img src="{{ asset('images/timeline.png') }}" alt="ระยะเวลาการผลิต" class="bank-banner-img">
                    </div>

                    <div class="production-notes">
                        <p class="note-head">** หมายเหตุ **</p>
                        
                        <p class="text-red red-note-text">กรณีที่สั่งผลิตสินค้า ไม่เกิน 3,000 ชิ้น</p>
                        
                        <ul class="note-list">
                            <li>หากต้องการสั่ง 3,000 ชิ้นขึ้นไป กรุณาติดต่อพนักงานขาย</li>
                            <li>วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์</li>
                            <li>หากต้องการใช้สินค้าเร่งด่วนสามารถสอบถามระยะเวลาการผลิตแบบด่วนได้ (อาจมีค่าใช้จ่ายเพิ่มเติม)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="info-card" id="section4">
                <div class="card-header">
                    <span class="card-icon">4</span>
                    <h5 class="payment-detail-title">การยกเลิกและเปลี่ยนแปลงคำสั่งซื้อ</h5>
                </div>
                <div class="card-body">
                    <div class="cancel-step mb-3">
                        <p>1.หากยัง ไม่ได้ชำระเงิน → ระบบจะยกเลิกรายการอัตโนมัติภายใน 7 วัน</p>
                    </div>

                    <div class="cancel-step">
                        <p>2.หาก ชำระเงินแล้ว → การยกเลิกจะมีค่าธรรมเนียมตามเงื่อนไข</p>
                        <ul class="cancel-list">
                            <li>ยกเลิกภายใน 3 วัน → หัก 30% ของยอดสั่งซื้อ</li>
                            <li>ยกเลิกภายใน 6 วัน → หัก 50% ของยอดสั่งซื้อ</li>
                            <li>ยกเลิกหลังจาก 6 วันขึ้นไป → หัก 100% ของยอดสั่งซื้อ</li>
                        </ul>
                    </div>
                    
                    <p class="contact-footer-text">
                        *** <span class="underline">สำหรับข้อสงสัยเพิ่มเติม กรุณาติดต่อฝ่ายบริการลูกค้า</span> ***
                    </p>
                </div>
            </div>

        </div> {{-- ปิด payment-grid --}}

        <h3 class="nav-title">บทความที่คุณอาจสนใจ</h3>
        <div class="related-nav">
            <div class="nav-links-container">
                <a href="{{ route('order-guide') }}" class="nav-link-item">
                    <span>ขั้นตอนการสั่งซื้อสินค้า</span>
                </a>
                <a href="{{ route('faq') }}" class="nav-link-item">
                    <span>คำถามที่พบบ่อย (FAQ)</span>
                </a>
                <a href="{{ route('design-guide') }}" class="nav-link-item">
                    <span>วิธีการออกแบบ</span>
                </a>
                <div class="faq-item" onclick="location.href='{{ route('payment-method') }}#section3'"> การจัดส่งสินค้า</div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyBtn = document.getElementById('copyAccountBtn');
        
        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const accNo = this.getAttribute('data-account');
                
                // ใช้ฟังก์ชันคัดลอกที่รองรับทุก Browser
                copyToClipboard(accNo, this);
            });
        }

        function copyToClipboard(text, btn) {
            if (navigator.clipboard && window.isSecureContext) {
                // สำหรับ HTTPS และ Browser ใหม่
                navigator.clipboard.writeText(text).then(() => {
                    showSuccess(btn);
                });
            } else {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed"; // ป้องกันหน้าจอเลื่อน
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    showSuccess(btn);
                } catch (err) {
                    console.error('Copy fallback failed', err);
                }
                document.body.removeChild(textArea);
            }
        }

        function showSuccess(btn) {
            const originalText = btn.innerText;
            btn.innerText = 'คัดลอกแล้ว ✓';
            btn.classList.add('copied');
            
            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.remove('copied');
            }, 2000);
        }
    });
</script>
@endsection